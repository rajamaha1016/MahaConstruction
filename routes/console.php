<?php

use Illuminate\Support\Facades\Schedule;

// Automatically sync YouTube channel videos hourly
Schedule::command('youtube:sync')->hourly();
