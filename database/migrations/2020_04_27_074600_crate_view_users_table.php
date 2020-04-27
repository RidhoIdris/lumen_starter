<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CrateViewUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW vw_ms_users AS
                        select a.id,a.name,a.email,a.created_at,a.updated_at,GROUP_CONCAT(c.`name`) as role from users as a
                        join model_has_roles as b on b.model_id = a.id
                        join roles as c on c.id = b.role_id 
                        GROUP BY a.id,a.created_at,a.email,a.`name` ,a.updated_at ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW vw_ms_users");
    }
}
