<?php

use Shomisha\Crudly\Developers\Crud\Api;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers;
use Shomisha\Crudly\Developers\Crud\PolicyDeveloper;
use Shomisha\Crudly\Developers\Crud\Web;
use Shomisha\Crudly\Developers\Factory;
use \Shomisha\Crudly\Developers\Migration;
use Shomisha\Crudly\Developers\Model;
use Shomisha\Crudly\Developers\NullDeveloper;
use Shomisha\Crudly\Developers\NullMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\Api as ApiTests;
use Shomisha\Crudly\Developers\Tests\Api\Methods as ApiTestMethods;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers as TestHelpers;
use Shomisha\Crudly\Developers\Tests\Web as WebTests;
use Shomisha\Crudly\Developers\Tests\Web\Methods as WebTestMethods;

return [
    'migrations' => Migration\MigrationDeveloper::class,
    'migrations.up-method' => Migration\UpMethodDeveloper::class,
    'migrations.fields' => Migration\MigrationFieldsDeveloper::class,
    'migrations.down-method' => Migration\DownMethodDeveloper::class,

    'model' => Model\ModelDeveloper::class,
    'model.soft-deletion' => Model\SoftDeletionDeveloper::class,
    'model.casts' => Model\CastsDeveloper::class,
    'model.relationships' => Model\RelationshipDeveloper::class,

    'policy' => PolicyDeveloper::class,

    'web.form-request' => Web\FormRequest\WebFormRequestDeveloper::class,
    'web.form-request.methods.authorize' => NullMethodDeveloper::class,
    'web.form-request.methods.rules' => PartialDevelopers\FormRequest\Rules\RulesMethodDeveloper::class,
    'web.form-request.methods.rules.special' => PartialDevelopers\FormRequest\Rules\SpecialRulesDeveloper::class,
    'web.form-request.methods.rules.validation' => PartialDevelopers\Validation\PropertyValidationRulesDeveloper::class,

    'web.controller' => Web\CrudControllerDeveloper::class,

    'web.controller.index'=> Web\Index\IndexDeveloper::class,
    'web.controller.index.arguments' => [],
    'web.controller.index.load' => NullDeveloper::class,
    'web.controller.index.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'viewAll', 'withClass' => true]),
    'web.controller.index.main' => PartialDevelopers\Load\PaginateDeveloper::class,
    'web.controller.index.response' => Web\Index\ResponseDeveloper::class,

    'web.controller.show'=> Web\Show\ShowDeveloper::class,
    'web.controller.show.arguments' => [
        PartialDevelopers\ImplicitBindArgumentsDeveloper::class
    ],
    'web.controller.show.load' => NullDeveloper::class,
    'web.controller.show.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'view', 'withModel' => true]),
    'web.controller.show.main' => PartialDevelopers\LoadRelationshipsDeveloper::class,
    'web.controller.show.response' => Web\Show\ResponseDeveloper::class,

    'web.controller.create'=> Web\Create\CreateDeveloper::class,
    'web.controller.create.arguments' => [],
    'web.controller.create.load' => NullDeveloper::class,
    'web.controller.create.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'create', 'withClass' => true]),
    'web.controller.create.main' => Web\Create\InstantiatePlaceholderAndLoadDependencies::class,
    'web.controller.create.main.instantiate' => PartialDevelopers\InstantiateDeveloper::class,
    'web.controller.create.main.load-dependencies' => PartialDevelopers\LoadDependenciesDeveloper::class,
    'web.controller.create.response' => Web\Create\ResponseDeveloper::class,

    'web.controller.store'=> Web\Store\StoreDeveloper::class,
    'web.controller.store.arguments' => [
        Web\Store\FormRequestArgumentDeveloper::class,
    ],
    'web.controller.store.load' => NullDeveloper::class,
    'web.controller.store.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'create', 'withClass' => true]),
    'web.controller.store.main' => Web\Store\ValidateFillAndSaveDeveloper::class,
    'web.controller.store.main.validate' => NullDeveloper::class,
    'web.controller.store.main.instantiate' => PartialDevelopers\InstantiateDeveloper::class,
    'web.controller.store.main.fill' => Web\Store\Fill\FillFieldsSeparatelyDeveloper::class,
    'web.controller.store.main.save' => developerClass(PartialDevelopers\InvokeModelMethodDeveloper::class, ['method' => 'save']),
    'web.controller.store.response' => Web\Store\ResponseDeveloper::class,

    'web.controller.edit'=> Web\Edit\EditDeveloper::class,
    'web.controller.edit.arguments' => [
        PartialDevelopers\ImplicitBindArgumentsDeveloper::class,
    ],
    'web.controller.edit.load' => NullDeveloper::class,
    'web.controller.edit.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'update', 'withModel' => true]),
    'web.controller.edit.main' => PartialDevelopers\LoadDependenciesDeveloper::class,
    'web.controller.edit.response' => Web\Edit\ResponseDeveloper::class,

    'web.controller.update'=> Web\Update\UpdateDeveloper::class,
    'web.controller.update.arguments' => [
        Web\Store\FormRequestArgumentDeveloper::class,
        PartialDevelopers\ImplicitBindArgumentsDeveloper::class,
    ],
    'web.controller.update.load' => NullDeveloper::class,
    'web.controller.update.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'update', 'withModel' => true]),
    'web.controller.update.main' => Web\Update\ValidateFillAndUpdateDeveloper::class,
    'web.controller.update.main.validate' => NullDeveloper::class,
    'web.controller.update.main.fill' => Web\Store\Fill\FillFieldsSeparatelyDeveloper::class,
    'web.controller.update.main.update' => developerClass(PartialDevelopers\InvokeModelMethodDeveloper::class, ['method' => 'update']),
    'web.controller.update.response' => Web\Update\ResponseDeveloper::class,

    'web.controller.destroy'=> Web\Destroy\DestroyDeveloper::class,
    'web.controller.destroy.arguments' => [
        PartialDevelopers\ImplicitBindArgumentsDeveloper::class,
    ],
    'web.controller.destroy.load' => NullDeveloper::class,
    'web.controller.destroy.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'delete', 'withModel' => true]),
    'web.controller.destroy.main' => developerClass(PartialDevelopers\InvokeModelMethodDeveloper::class, ['method' => 'delete']),
    'web.controller.destroy.response' => Web\Destroy\ResponseDeveloper::class,

    'web.controller.force-delete' => Web\ForceDelete\ForceDeleteDeveloper::class,
    'web.controller.force-delete.arguments' => [
        PartialDevelopers\ImplicitBindArgumentsDeveloper::class
    ],
    'web.controller.force-delete.load' => NullDeveloper::class,
    'web.controller.force-delete.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'forceDelete', 'withModel' => true]),
    'web.controller.force-delete.main' => developerClass(PartialDevelopers\InvokeModelMethodDeveloper::class, ['method' => 'forceDelete']),
    'web.controller.force-delete.response' => Web\ForceDelete\ResponseDeveloper::class,

    'web.controller.restore'=> Web\Restore\RestoreDeveloper::class,
    'web.controller.restore.arguments' => [
        PartialDevelopers\ImplicitBindArgumentsDeveloper::class
    ],
    'web.controller.restore.load' => NullDeveloper::class,
    'web.controller.restore.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'restore', 'withModel' => true]),
    'web.controller.restore.main' => developerClass(PartialDevelopers\InvokeModelMethodDeveloper::class, ['method' => 'restore']),
    'web.controller.restore.response' => Web\Restore\ResponseDeveloper::class,

    'api.form-request' => Api\FormRequest\ApiFormRequestDeveloper::class,
    'api.form-request.methods.authorize' => NullMethodDeveloper::class,
    'api.form-request.methods.rules' => PartialDevelopers\FormRequest\Rules\RulesMethodDeveloper::class,
    'api.form-request.methods.rules.special' => PartialDevelopers\FormRequest\Rules\SpecialRulesDeveloper::class,
    'api.form-request.methods.rules.validation' => PartialDevelopers\Validation\PropertyValidationRulesDeveloper::class,

    'api.resource' => Api\Resource\ApiResourceDeveloper::class,
    'api.resource.to-array-method' => Api\Resource\ToArrayMethodDeveloper::class,
    'api.resource.property-resource-mapping' => Api\Resource\PropertyResourceMappingDeveloper::class,

    'api.controller' => Api\CrudControllerDeveloper::class,

    'api.controller.index'=> Api\Index\IndexDeveloper::class,
    'api.controller.index.arguments' => [],
    'api.controller.index.load' => NullDeveloper::class,
    'api.controller.index.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'viewAll', 'withClass' => true]),
    'api.controller.index.main' => PartialDevelopers\Load\PaginateDeveloper::class,
    'api.controller.index.response' => Api\Index\ResponseDeveloper::class,

    'api.controller.show'=> Api\Show\ShowDeveloper::class,
    'api.controller.show.arguments' => [
        PartialDevelopers\ImplicitBindArgumentsDeveloper::class
    ],
    'api.controller.show.load' => NullDeveloper::class,
    'api.controller.show.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'view', 'withModel' => true]),
    'api.controller.show.main' => PartialDevelopers\LoadRelationshipsDeveloper::class,
    'api.controller.show.response' => PartialDevelopers\ReturnSingleResourceDeveloper::class,

    'api.controller.store'=> Api\Store\StoreDeveloper::class,
    'api.controller.store.arguments' => [
        Web\Store\FormRequestArgumentDeveloper::class,
    ],
    'api.controller.store.load' => NullDeveloper::class,
    'api.controller.store.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'create', 'withClass' => true]),
    'api.controller.store.main' => Api\Store\InstantiateFillAndSaveDeveloper::class,
    'api.controller.store.main.validate' => NullDeveloper::class,
    'api.controller.store.main.instantiate' => PartialDevelopers\InstantiateDeveloper::class,
    'api.controller.store.main.fill' => Web\Store\Fill\FillFieldsSeparatelyDeveloper::class,
    'api.controller.store.main.save' => developerClass(PartialDevelopers\InvokeModelMethodDeveloper::class, ['method' => 'save']),
    'api.controller.store.response' => PartialDevelopers\ReturnSingleResourceDeveloper::class,

    'api.controller.update'=> Api\Update\UpdateDeveloper::class,
    'api.controller.update.arguments' => [
        Web\Store\FormRequestArgumentDeveloper::class,
        PartialDevelopers\ImplicitBindArgumentsDeveloper::class,
    ],
    'api.controller.update.load' => NullDeveloper::class,
    'api.controller.update.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'update', 'withModel' => true]),
    'api.controller.update.main' => Web\Update\ValidateFillAndUpdateDeveloper::class,
    'api.controller.update.main.validate' => NullDeveloper::class,
    'api.controller.update.main.fill' => Web\Store\Fill\FillFieldsSeparatelyDeveloper::class,
    'api.controller.update.main.update' => developerClass(PartialDevelopers\InvokeModelMethodDeveloper::class, ['method' => 'update']),
    'api.controller.update.response' => PartialDevelopers\ReturnNoContentDeveloper::class,

    'api.controller.destroy'=> Api\Destroy\DestroyDeveloper::class,
    'api.controller.destroy.arguments' => [
        PartialDevelopers\ImplicitBindArgumentsDeveloper::class,
    ],
    'api.controller.destroy.load' => NullDeveloper::class,
    'api.controller.destroy.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'delete', 'withModel' => true]),
    'api.controller.destroy.main' => developerClass(PartialDevelopers\InvokeModelMethodDeveloper::class, ['method' => 'delete']),
    'api.controller.destroy.response' => PartialDevelopers\ReturnNoContentDeveloper::class,

    'api.controller.force-delete' => Api\ForceDelete\ForceDeleteDeveloper::class,
    'api.controller.force-delete.arguments' => [
        PartialDevelopers\ImplicitBindArgumentsDeveloper::class
    ],
    'api.controller.force-delete.load' => NullDeveloper::class,
    'api.controller.force-delete.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'forceDelete', 'withModel' => true]),
    'api.controller.force-delete.main' => developerClass(PartialDevelopers\InvokeModelMethodDeveloper::class, ['method' => 'forceDelete']),
    'api.controller.force-delete.response' => PartialDevelopers\ReturnNoContentDeveloper::class,

    'api.controller.restore'=> Api\Restore\RestoreDeveloper::class,
    'api.controller.restore.arguments' => [
        PartialDevelopers\ImplicitBindArgumentsDeveloper::class
    ],
    'api.controller.restore.load' => NullDeveloper::class,
    'api.controller.restore.authorization' => developerClass(PartialDevelopers\InvokeAuthorizationDeveloper::class, ['action' => 'restore', 'withModel' => true]),
    'api.controller.restore.main' => developerClass(PartialDevelopers\InvokeModelMethodDeveloper::class, ['method' => 'restore']),
    'api.controller.restore.response' => PartialDevelopers\ReturnNoContentDeveloper::class,

    'factory' => Factory\FactoryClassDeveloper::class,
    'factory.model-property' => Factory\FactoryModelPropertyDeveloper::class,
    'factory.definition-method' => Factory\DefinitionMethodDeveloper::class,
    'factory.definition-fields' => Factory\FactoryDefinitionFieldDeveloper::class,

    'web.tests' => WebTests\WebTestsDeveloper::class,
    'web.tests.helpers' => [
        TestHelpers\AuthenticateUserMethodDeveloper::class,
        TestHelpers\GetModelDataMethodDeveloper::class,
    ],

    'web.tests.helpers.routes' => [
        TestHelpers\RouteGetters\GetIndexRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetShowRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetCreateRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetStoreRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetEditRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetUpdateRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetDestroyRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetForceDeleteRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetRestoreRouteMethodDeveloper::class,
    ],

    'web.tests.helpers.authorization' => [
        TestHelpers\AuthorizeUserMethodDeveloper::class,
        TestHelpers\DeauthorizeUserMethodDeveloper::class,
    ],

    'web.tests.helpers.invalid-data-provider' => WebTestMethods\InvalidDataProviderDeveloper::class,

    'web.tests.index' => WebTestMethods\Index\IndexTestDeveloper::class,
    'web.tests.index.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateMultipleModelInstances::class,
    ],
    'web.tests.index.act' => [
        PartialDevelopers\Tests\Requests\GetIndexRouteDeveloper::class,
    ],
    'web.tests.index.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseSuccessfulDeveloper::class,
        developerClass(PartialDevelopers\Tests\Assertions\AssertViewIsDeveloper::class, ['view' => 'index']),
        PartialDevelopers\Tests\GetModelIdsFromResponseDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertResponseModelIdsCountSameAsModels::class,
        PartialDevelopers\Tests\Assertions\AssertAllModelIdsPresentDeveloper::class,
    ],

    'web.tests.index.unauthorized' => WebTestMethods\Index\UnauthorizedIndexTestDeveloper::class,
    'web.tests.index.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
    ],
    'web.tests.index.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\GetIndexRouteDeveloper::class,
    ],
    'web.tests.index.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
    ],

    'web.tests.index.missing-soft-deleted' => WebTestMethods\Index\IndexWillNotContainSoftDeletedModelsTestDeveloper::class,
    'web.tests.index.missing-soft-deleted.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateMultipleModelInstances::class,
        PartialDevelopers\Tests\Factory\CreateSoftDeletedInstance::class,
    ],
    'web.tests.index.missing-soft-deleted.act' => [
        PartialDevelopers\Tests\Requests\GetIndexRouteDeveloper::class,
    ],
    'web.tests.index.missing-soft-deleted.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseSuccessfulDeveloper::class,
        developerClass(PartialDevelopers\Tests\Assertions\AssertViewIsDeveloper::class, ['view' => 'index']),
        PartialDevelopers\Tests\GetModelIdsFromResponseDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertResponseModelsMissingSingularModel::class,
    ],


    'web.tests.show' => WebTestMethods\Show\ShowTestDeveloper::class,
    'web.tests.show.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'web.tests.show.act' => [
        PartialDevelopers\Tests\Requests\GetShowRouteDeveloper::class,
    ],
    'web.tests.show.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseSuccessfulDeveloper::class,
        developerClass(PartialDevelopers\Tests\Assertions\AssertViewIsDeveloper::class, ['view' => 'show']),
        PartialDevelopers\Tests\Assertions\AssertResponseModelIsTestModel::class,
    ],

    'web.tests.show.unauthorized' => WebTestMethods\Show\UnauthorizedShowTestDeveloper::class,
    'web.tests.show.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'web.tests.show.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\GetShowRouteDeveloper::class,
    ],
    'web.tests.show.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
    ],


    'web.tests.create' => WebTestMethods\Create\CreateTestDeveloper::class,
    'web.tests.create.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
    ],
    'web.tests.create.act' => [
        PartialDevelopers\Tests\Requests\LoadCreatePageDeveloper::class,
    ],
    'web.tests.create.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseSuccessfulDeveloper::class,
        developerClass(PartialDevelopers\Tests\Assertions\AssertViewIsDeveloper::class, ['view' => 'create']),
    ],

    'web.tests.create.unauthorized' => WebTestMethods\Create\UnauthorizedCreateTestDeveloper::class,
    'web.tests.create.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
    ],
    'web.tests.create.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\LoadCreatePageDeveloper::class,
    ],
    'web.tests.create.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
    ],


    'web.tests.store' => WebTestMethods\Store\StoreTestDeveloper::class,
    'web.tests.store.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper::class,
    ],
    'web.tests.store.act' => [
        PartialDevelopers\Tests\Requests\PostDataToStoreRouteDeveloper::class,
    ],
    'web.tests.store.assert' => [
        PartialDevelopers\Tests\Assertions\AssertRedirectToIndexDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSessionHasSuccessDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertDatabaseContainsNewModel::class,
    ],

    'web.tests.store.invalid' => WebTestMethods\Store\InvalidStoreTestDeveloper::class,
    'web.tests.store.invalid.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithInvalidOverrideDeveloper::class,
    ],
    'web.tests.store.invalid.act' => [
        PartialDevelopers\Tests\Requests\PostDataToStoreRouteFromIndexRouteDeveloper::class,
    ],
    'web.tests.store.invalid.assert' => [
        PartialDevelopers\Tests\Assertions\AssertRedirectToIndexDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSessionHasFieldErrorDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertDatabaseHasNoModels::class,
    ],

    'web.tests.store.unauthorized' => WebTestMethods\Store\UnauthorizedStoreTestDeveloper::class,
    'web.tests.store.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithoutOverrideDeveloper::class,
    ],
    'web.tests.store.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\PostDataToStoreRouteDeveloper::class,
    ],
    'web.tests.store.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertDatabaseHasNoModels::class,
    ],


    'web.tests.edit' => WebTestMethods\Edit\EditTestDeveloper::class,
    'web.tests.edit.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'web.tests.edit.act' => [
        PartialDevelopers\Tests\Requests\LoadEditPageDeveloper::class,
    ],
    'web.tests.edit.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseSuccessfulDeveloper::class,
        developerClass(PartialDevelopers\Tests\Assertions\AssertViewIsDeveloper::class, ['view' => 'edit']),
        PartialDevelopers\Tests\Assertions\AssertResponseModelIsTestModel::class,
    ],

    'web.tests.edit.unauthorized' => WebTestMethods\Edit\UnauthorizedEditTestDeveloper::class,
    'web.tests.edit.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'web.tests.edit.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\LoadEditPageDeveloper::class,
    ],
    'web.tests.edit.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
    ],


    'web.tests.update' => WebTestMethods\Update\UpdateTestDeveloper::class,
    'web.tests.update.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateModelWithOldDefaultsDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper::class,
    ],
    'web.tests.update.act' => [
        PartialDevelopers\Tests\Requests\PutDataToUpdateRouteDeveloper::class,
    ],
    'web.tests.update.assert' => [
        PartialDevelopers\Tests\Assertions\AssertRedirectToIndexDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSessionHasSuccessDeveloper::class,
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertModelUpdatedWithNewValuesDeveloper::class,
    ],

    'api.tests.update.invalid' => ApiTestMethods\Update\InvalidUpdateTestDeveloper::class,
    'api.tests.update.invalid.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateModelWithOldDefaultsDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithInvalidOverrideDeveloper::class,
    ],
    'api.tests.update.invalid.act' => [
        PartialDevelopers\Tests\Requests\PutDataToUpdateRouteDeveloper::class,
    ],
    'api.tests.update.invalid.assert' => [
        developerClass(PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper::class, ['status' => 422]),
        PartialDevelopers\Tests\Assertions\AssertJsonHasFieldErrorDeveloper::class,
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertModelHasOldValuesDeveloper::class,
    ],

    'api.tests.update.unauthorized' => ApiTestMethods\Update\UnauthorizedUpdateTestDeveloper::class,
    'api.tests.update.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateModelWithOldDefaultsDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper::class,
    ],
    'api.tests.update.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\PutDataToUpdateRouteDeveloper::class,
    ],
    'api.tests.update.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertModelHasOldValuesDeveloper::class,
    ],


    'api.tests.destroy' => ApiTestMethods\Destroy\DestroyTestDeveloper::class,
    'api.tests.destroy.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'api.tests.destroy.act' => [
        PartialDevelopers\Tests\Requests\DeleteDestroyRouteDeveloper::class,
    ],
    'api.tests.destroy.assert' => [
        developerClass(PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper::class, ['status' => 204]),
        PartialDevelopers\Tests\Assertions\AssertModelDeletedDeveloper::class, // TODO: make this developer configurable
    ],

    'api.tests.destroy.unauthorized' => ApiTestMethods\Destroy\UnauthorizedDestroyTestDeveloper::class,
    'api.tests.destroy.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'api.tests.destroy.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\DeleteDestroyRouteDeveloper::class,
    ],
    'api.tests.destroy.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertModelNotDeletedDeveloper::class, // TODO: make this developer configurable
    ],


    'api.tests.force-delete' => ApiTestMethods\ForceDelete\ForceDeleteTestDeveloper::class,
    'api.tests.force-delete.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'api.tests.force-delete.act' => [
        PartialDevelopers\Tests\Requests\DeleteForceDeleteRouteDeveloper::class,
    ],
    'api.tests.force-delete.assert' => [
        developerClass(PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper::class, ['status' => 204]),
        PartialDevelopers\Tests\Assertions\AssertDatabaseMissingModelDeveloper::class,
    ],

    'api.tests.force-delete.unauthorized' => ApiTestMethods\ForceDelete\UnauthorizedForceDeleteTestDeveloper::class,
    'api.tests.force-delete.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'api.tests.force-delete.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\DeleteForceDeleteRouteDeveloper::class,
    ],
    'api.tests.force-delete.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNull::class,
    ],


    'web.tests.restore' => WebTestMethods\Restore\RestoreTestDeveloper::class,
    'web.tests.restore.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSoftDeletedInstance::class,
    ],
    'web.tests.restore.act' => [
        PartialDevelopers\Tests\Requests\PatchRestoreRouteDeveloper::class,
    ],
    'web.tests.restore.assert' => [
        PartialDevelopers\Tests\Assertions\AssertRedirectToIndexDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSessionHasSuccessDeveloper::class,
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNull::class,
    ],

    'web.tests.restore.unauthorized' => WebTestMethods\Restore\UnauthorizedRestoreTestDeveloper::class,
    'web.tests.restore.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSoftDeletedInstance::class,
    ],
    'web.tests.restore.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\PatchRestoreRouteDeveloper::class,
    ],
    'web.tests.restore.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNotNull::class,
    ],

    'api.tests' => ApiTests\ApiTestsDeveloper::class,
    'api.tests.helpers' => [
        TestHelpers\AuthenticateUserMethodDeveloper::class,
        TestHelpers\GetModelDataMethodDeveloper::class,
    ],

    'api.tests.helpers.authorization' => [
        TestHelpers\AuthorizeUserMethodDeveloper::class,
        TestHelpers\DeauthorizeUserMethodDeveloper::class,
    ],

    'api.tests.helpers.routes' => [
        TestHelpers\RouteGetters\GetIndexRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetShowRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetStoreRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetUpdateRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetDestroyRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetForceDeleteRouteMethodDeveloper::class,
        TestHelpers\RouteGetters\GetRestoreRouteMethodDeveloper::class,
    ],

    'api.tests.helpers.invalid-data-provider' => WebTestMethods\InvalidDataProviderDeveloper::class,

    'api.tests.index' => ApiTestMethods\Index\IndexTestDeveloper::class,
    'api.tests.index.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateMultipleModelInstances::class,
    ],
    'api.tests.index.act' => [
        PartialDevelopers\Tests\Requests\GetIndexRouteDeveloper::class,
    ],
    'api.tests.index.assert' => [
        developerClass(PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper::class, ['status' => 200]),
        PartialDevelopers\Tests\GetModelIdsFromJsonDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertResponseModelIdsCountSameAsModels::class,
        PartialDevelopers\Tests\Assertions\AssertJsonResponseContainsAllModels::class,
    ],

    'api.tests.index.unauthorized' => ApiTestMethods\Index\UnauthorizedIndexTestDeveloper::class,
    'api.tests.index.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
    ],
    'api.tests.index.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\GetIndexRouteDeveloper::class,
    ],
    'api.tests.index.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
    ],


    'api.tests.show' => ApiTestMethods\Show\ShowTestDeveloper::class,
    'api.tests.show.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'api.tests.show.act' => [
        PartialDevelopers\Tests\Requests\GetShowRouteDeveloper::class,
    ],
    'api.tests.show.assert' => [
        developerClass(PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper::class, ['status' => 200]),
        PartialDevelopers\Tests\Assertions\AssertModelIsJsonModel::class,
    ],

    'api.tests.show.unauthorized' => ApiTestMethods\Show\UnauthorizedShowTestDeveloper::class,
    'api.tests.show.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'api.tests.show.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\GetShowRouteDeveloper::class,
    ],
    'api.tests.show.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
    ],


    'api.tests.store' => ApiTestMethods\Store\StoreTestDeveloper::class,
    'api.tests.store.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper::class,
    ],
    'api.tests.store.act' => [
        PartialDevelopers\Tests\Requests\PostDataToStoreRouteDeveloper::class,
    ],
    'api.tests.store.assert' => [
        developerClass(PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper::class, ['status' => 201]),
        PartialDevelopers\Tests\Assertions\AssertDatabaseContainsNewModel::class,
    ],

    'api.tests.store.invalid' => ApiTestMethods\Store\InvalidStoreTestDeveloper::class,
    'api.tests.store.invalid.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithInvalidOverrideDeveloper::class,
    ],
    'api.tests.store.invalid.act' => [
        PartialDevelopers\Tests\Requests\PostDataToStoreRouteDeveloper::class,
    ],
    'api.tests.store.invalid.assert' => [
        developerClass(PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper::class, ['status' => 422]),
        PartialDevelopers\Tests\Assertions\AssertJsonHasFieldErrorDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertDatabaseHasNoModels::class,
    ],

    'api.tests.store.unauthorized' => ApiTestMethods\Store\UnauthorizedStoreTestDeveloper::class,
    'api.tests.store.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper::class,
    ],
    'api.tests.store.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\PostDataToStoreRouteDeveloper::class,
    ],
    'api.tests.store.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertDatabaseHasNoModels::class,
    ],


    'api.tests.update' => ApiTestMethods\Update\UpdateTestDeveloper::class,
    'api.tests.update.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateModelWithOldDefaultsDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper::class,
    ],
    'api.tests.update.act' => [
        PartialDevelopers\Tests\Requests\PutDataToUpdateRouteDeveloper::class,
    ],
    'api.tests.update.assert' => [
        developerClass(PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper::class, ['status' => 204]),
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertModelUpdatedWithNewValuesDeveloper::class,
    ],

    'web.tests.update.invalid' => WebTestMethods\Update\InvalidUpdateTestDeveloper::class,
    'web.tests.update.invalid.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateModelWithOldDefaultsDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithInvalidOverrideDeveloper::class,
    ],
    'web.tests.update.invalid.act' => [
        PartialDevelopers\Tests\Requests\PutDataToUpdateRouteFromIndexRouteDeveloper::class,
    ],
    'web.tests.update.invalid.assert' => [
        PartialDevelopers\Tests\Assertions\AssertRedirectToIndexDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSessionHasFieldErrorDeveloper::class,
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertModelHasOldValuesDeveloper::class,
    ],

    'web.tests.update.unauthorized' => WebTestMethods\Update\UnauthorizedUpdateTestDeveloper::class,
    'web.tests.update.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateModelWithOldDefaultsDeveloper::class,
        PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper::class,
    ],
    'web.tests.update.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\PutDataToUpdateRouteDeveloper::class,
    ],
    'web.tests.update.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertModelHasOldValuesDeveloper::class,
    ],


    'web.tests.destroy' => WebTestMethods\Destroy\DestroyTestDeveloper::class,
    'web.tests.destroy.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'web.tests.destroy.act' => [
        PartialDevelopers\Tests\Requests\DeleteDestroyRouteDeveloper::class,
    ],
    'web.tests.destroy.assert' => [
        PartialDevelopers\Tests\Assertions\AssertRedirectToIndexDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSessionHasSuccessDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertModelDeletedDeveloper::class, // TODO: make this developer configurable
    ],

    'web.tests.destroy.unauthorized' => WebTestMethods\Destroy\UnauthorizedDestroyTestDeveloper::class,
    'web.tests.destroy.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'web.tests.destroy.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\DeleteDestroyRouteDeveloper::class,
    ],
    'web.tests.destroy.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertModelNotDeletedDeveloper::class, // TODO: make this developer configurable
    ],


    'web.tests.force-delete' => WebTestMethods\ForceDelete\ForceDeleteTestDeveloper::class,
    'web.tests.force-delete.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'web.tests.force-delete.act' => [
        PartialDevelopers\Tests\Requests\DeleteForceDeleteRouteDeveloper::class,
    ],
    'web.tests.force-delete.assert' => [
        PartialDevelopers\Tests\Assertions\AssertRedirectToIndexDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSessionHasSuccessDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertDatabaseMissingModelDeveloper::class,
    ],

    'web.tests.force-delete.unauthorized' => ApiTestMethods\ForceDelete\UnauthorizedForceDeleteTestDeveloper::class,
    'web.tests.force-delete.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSingleModelInstance::class,
    ],
    'web.tests.force-delete.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\DeleteForceDeleteRouteDeveloper::class,
    ],
    'web.tests.force-delete.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNull::class,
    ],


    'api.tests.restore' => ApiTestMethods\Restore\RestoreTestDeveloper::class,
    'api.tests.restore.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSoftDeletedInstance::class,
    ],
    'api.tests.restore.act' => [
        PartialDevelopers\Tests\Requests\PatchRestoreRouteDeveloper::class,
    ],
    'api.tests.restore.assert' => [
        developerClass(PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper::class, ['status' => 204]),
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNull::class,
    ],

    'api.tests.restore.unauthorized' => ApiTestMethods\Restore\UnauthorizedRestoreTestDeveloper::class,
    'api.tests.restore.unauthorized.arrange' => [
        PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper::class,
        PartialDevelopers\Tests\Factory\CreateSoftDeletedInstance::class,
    ],
    'api.tests.restore.unauthorized.act' => [
        PartialDevelopers\Tests\Requests\PatchRestoreRouteDeveloper::class,
    ],
    'api.tests.restore.unauthorized.assert' => [
        PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper::class,
        PartialDevelopers\Tests\RefreshModelDeveloper::class,
        PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNotNull::class,
    ],
];
