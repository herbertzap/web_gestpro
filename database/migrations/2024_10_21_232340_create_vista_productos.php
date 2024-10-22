<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS vista_productos');
        DB::statement("
            CREATE VIEW vista_productos AS
            SELECT 
                dbo.TABFM.KOFM AS codigo_producto,
                dbo.TABFM.NOKOFM AS nombre_producto,
                dbo.TABPF.KOPF AS codigo_subcategoria,
                dbo.TABPF.NOKOPF AS nombre_subcategoria,
                dbo.TABHF.KOHF AS codigo_categoria,
                dbo.TABHF.NOKOHF AS nombre_categoria
            FROM 
                dbo.TABFM
            INNER JOIN 
                dbo.TABPF ON dbo.TABFM.KOFM = dbo.TABPF.KOFM
            INNER JOIN 
                dbo.TABHF ON dbo.TABPF.KOFM = dbo.TABHF.KOFM 
                AND dbo.TABPF.KOPF = dbo.TABHF.KOPF;
        ");
    }
    
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS vista_productos');
    }
};
