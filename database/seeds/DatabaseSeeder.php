<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

        //create roles
        $roleManager = Role::create(['name' => 'Manager']);
        $roleTester = Role::create(['name' => 'Tester']);
        $roleProgrammer = Role::create(['name' => 'Programmer']);

        //create permission
        $permissionEditIssue = Permission::create(['name' => 'edit_issues']);
        $permissionCreateIssue = Permission::create(['name' => 'create_issues']);
        $permissionCommentIssue = Permission::create(['name' => 'comment_issues']);
        $permissionChangeStatus = Permission::create(['name' => 'change_status']);
        $permissionAttachFile = Permission::create(['name' => 'attach_file']);
        $permissionInviteMember = Permission::create(['name' => 'invite_member']);

        //assign permission to Manager
        $permissionEditIssue->assignRole($roleManager);
        $permissionCreateIssue->assignRole($roleManager);
        $permissionCommentIssue->assignRole($roleManager);
        $permissionChangeStatus->assignRole($roleManager);
        $permissionAttachFile->assignRole($roleManager);
        $permissionInviteMember->assignRole($roleManager);

        //assign permission to Tester
        $permissionEditIssue->assignRole($roleTester);
        $permissionCreateIssue->assignRole($roleTester);
        $permissionCommentIssue->assignRole($roleTester);
        $permissionAttachFile->assignRole($roleTester);

        //assign permission to Programmer
        $permissionCommentIssue->assignRole($roleProgrammer);
        $permissionChangeStatus->assignRole($roleProgrammer);
    }
}
