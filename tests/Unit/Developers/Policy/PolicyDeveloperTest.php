<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Policy;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PolicyDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class PolicyDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_policy()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->softDeletes();


        $developer = new PolicyDeveloper($this->manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $policy = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertInstanceOf(ClassTemplate::class, $policy);
        $this->assertEquals($policy, $developedSet->getPolicy());

        $printedPolicy = $policy->print();
        $this->assertStringContainsString("use App\Models\Post;", $printedPolicy);
        $this->assertStringContainsString("use App\Models\User;", $printedPolicy);
        $this->assertStringContainsString("use Shomisha\Crudly\Exceptions\IncompletePolicyException;", $printedPolicy);

        $this->assertStringContainsString(implode("\n", [
            "class PostPolicy",
            "{",
            "    public function viewAny(User \$user)",
            "    {",
            "        throw IncompletePolicyException::missingAction('viewAny');",
            "    }\n",
            "    public function view(User \$user, Post \$post)",
            "    {",
            "        throw IncompletePolicyException::missingAction('view');",
            "    }\n",
            "    public function create(User \$user)",
            "    {",
            "        throw IncompletePolicyException::missingAction('create');",
            "    }\n",
            "    public function update(User \$user, Post \$post)",
            "    {",
            "        throw IncompletePolicyException::missingAction('update');",
            "    }\n",
            "    public function delete(User \$user, Post \$post)",
            "    {",
            "        throw IncompletePolicyException::missingAction('delete');",
            "    }\n",
            "    public function forceDelete(User \$user, Post \$post)",
            "    {",
            "        throw IncompletePolicyException::missingAction('forceDelete');",
            "    }\n",
            "    public function restore(User \$user, Post \$post)",
            "    {",
            "        throw IncompletePolicyException::missingAction('restore');",
            "    }",
            "}",
        ]), $printedPolicy);
    }

    /** @test */
    public function developer_will_not_develop_force_delete_and_restore_authorization_method_if_soft_deletion_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->softDeletes(false);


        $developer = new PolicyDeveloper($this->manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $policy = $developer->develop($specificationBuilder->build(), $developedSet);


        $printedPolicy = $policy->print();

        $this->assertStringNotContainsString("public function forceDelete", $printedPolicy);
        $this->assertStringNotContainsString("public function restore", $printedPolicy);
    }
}
