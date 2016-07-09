<?php



use Illuminate\Database\Seeder;



class SentinelDatabaseSeeder extends Seeder

{

    /**

     * Run the database seeds.

     *

     * @return void

     */

    public function run()

    {

        // Create Users

        DB::table('users')->truncate();



        $admin = Sentinel::getUserRepository()->create(array(

            'email'    => 'admin@admin.com',
            'password' => 'admin'

        ));



        $agent = Sentinel::getUserRepository()->create(array(

            'email'    => 'agent@agent.com',
            'password' => 'agent'

        ));

        $operator = Sentinel::getUserRepository()->create(array(

            'email'    => 'operator@operator.com',
            'password' => 'operator'

        ));


        // Create Activations

        DB::table('activations')->truncate();

        $code = Activation::create($admin)->code;

        Activation::complete($admin, $code);

        $code = Activation::create($agent)->code;

        Activation::complete($agent, $code);

        $code = Activation::create($operator)->code;

        Activation::complete($operator, $code);


        // Create Roles

        $administratorRole = Sentinel::getRoleRepository()->create(array(

            'name' => 'Administrator',

            'slug' => 'administrator',

            'permissions' => array(

                'users.create' => true,

                'users.update' => true,

                'users.view' => true,

                'users.destroy' => true,

                'roles.create' => true,

                'roles.update' => true,

                'roles.view' => true,

                'roles.delete' => true

            )

        ));

        $agentRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Agent',
            'slug' => 'agent',
            'permissions' => array()
        ));

        $salesmanRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Salesman',
            'slug' => 'salesman',
            'permissions' => array()
        ));

        $operatorRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Operator',
            'slug' => 'operator',
            'permissions' => array()
        ));


        // Assign Roles to Users

        $administratorRole->users()->attach($admin);

        $agentRole->users()->attach($agent);

        $operatorRole->users()->attach($operator);

    }

}