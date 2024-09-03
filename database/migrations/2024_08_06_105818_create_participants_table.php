<?php

Schema::create('participants', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->onDelete('cascade');
    $table->string('participant_name');
    $table->string('email');
    $table->timestamps();
});
