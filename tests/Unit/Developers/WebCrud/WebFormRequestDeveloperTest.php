<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Web\FormRequest\WebFormRequestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Crud\Web\WebFormRequestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class WebFormRequestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_web_form_request()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('title', ModelPropertyType::STRING())
                ->unique()
            ->property('body', ModelPropertyType::TEXT())
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
                ->isRelationship('author');


        $manager = new WebFormRequestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new WebFormRequestDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $formRequest = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertInstanceOf(ClassTemplate::class, $formRequest);
        $this->assertEquals($developedSet->getWebCrudFormRequest(), $formRequest);

        $printedFormRequest = $formRequest->print();
        $this->assertStringContainsString("namespace App\Http\Requests\Web;", $printedFormRequest);
        $this->assertStringContainsString("use Illuminate\Foundation\Http\FormRequest;", $printedFormRequest);
        $this->assertStringContainsString("use Illuminate\Validation\Rule;", $printedFormRequest);

        $this->assertStringContainsString(implode("\n", [
            "class PostRequest extends FormRequest",
            "{",
            "    public function rules()",
            "    {",
            "        \$titleUniqueRule = Rule::unique('posts', 'title');",
            "        \$authorIdExistsRule = Rule::exists('authors', 'id');",
            "        \$post = \$this->route('post');",
            "        if (\$post) {",
            "            \$titleUniqueRule->ignore(\$post->id);",
            "        }\n",
            "        return ['title' => [\$titleUniqueRule, 'required', 'string', 'max:255'], 'body' => ['required', 'string', 'max:65535'], 'author_id' => [\$authorIdExistsRule, 'required', 'integer']];",
            "    }",
            "}",
        ]), $printedFormRequest);
    }

    /** @test */
    public function developer_will_delegate_methods_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');

        $this->manager->methodDevelopers([
            'getAuthorizeMethodDeveloper',
            'getRulesMethodDeveloper',
        ]);


        $developer = new WebFormRequestDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertMethodDeveloperRequested('getAuthorizeMethodDeveloper');
        $this->manager->assertMethodDeveloperRequested('getRulesMethodDeveloper');
    }
}
