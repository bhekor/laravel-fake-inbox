<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inbox_id')->constrained()->cascadeOnDelete();
            $table->string('message_id')->unique();
            $table->string('subject');
            $table->json('from');
            $table->json('to');
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->json('reply_to')->nullable();
            $table->text('html_body')->nullable();
            $table->text('text_body')->nullable();
            $table->text('raw_body');
            $table->text('headers');
            $table->boolean('is_spam')->default(false);
            $table->float('spam_score')->default(0);
            $table->string('forwarded_to')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inbox_emails');
    }
};