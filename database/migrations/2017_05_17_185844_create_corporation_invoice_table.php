<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorporationInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'corporation_invoice', function( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'corporation_id' );
            $table->unsignedInteger( 'invoice_id' );
            $table->softDeletes();
            $table->timestamps();
        } );
        Schema::table( 'corporation_invoice', function( Blueprint $table ) {
            $table->foreign( 'corporation_id' )->references( 'id' )->on( 'corporations' )->onDelete( 'cascade' );
            $table->foreign( 'invoice_id' )->references( 'id' )->on( 'invoices' )->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists( 'corporation_invoice' );
    }
}
