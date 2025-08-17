<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('barcode')->nullable()->unique(); // Code-barres
            $table->string('qr_code')->nullable(); // QR Code généré
            $table->decimal('alert_threshold', 8, 2)->nullable(); // Seuil d'alerte personnalisé
            $table->json('custom_attributes')->nullable(); // Attributs personnalisés en JSON
            $table->string('brand')->nullable(); // Marque
            $table->string('model')->nullable(); // Modèle
            $table->date('expiry_date')->nullable(); // Date d'expiration
            $table->string('batch_number')->nullable(); // Numéro de lot
            $table->string('serial_number')->nullable(); // Numéro de série
            $table->decimal('weight', 8, 3)->nullable(); // Poids
            $table->string('dimensions')->nullable(); // Dimensions (LxWxH)
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'barcode', 'qr_code', 'alert_threshold', 'custom_attributes',
                'brand', 'model', 'expiry_date', 'batch_number', 'serial_number',
                'weight', 'dimensions'
            ]);
        });
    }
};
