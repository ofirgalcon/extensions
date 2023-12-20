<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class ExtensionsAddSystemextensions extends Migration
{
    private $tableName = 'extensions';

    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->string('boot_uuid')->nullable();
            $table->boolean('developer_mode')->nullable();
            $table->text('extension_policies')->nullable();
            $table->string('state')->nullable();
            $table->string('categories')->nullable();

            $table->index('boot_uuid');
            $table->index('developer_mode');
            $table->index('state');
        });
    }

    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->dropColumn('boot_uuid');
            $table->dropColumn('developer_mode');
            $table->dropColumn('extension_policies');
            $table->dropColumn('state');
            $table->dropColumn('categories');
        });
    }
}
