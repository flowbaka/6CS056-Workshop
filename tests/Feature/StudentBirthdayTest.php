<?php

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('student age changes on the birthday', function (string $today, int $expectedAge) {
    $this->travelTo(Carbon::parse($today));
    $student = Student::factory()->create(['date_of_birth' => '2000-04-12']);

    $this->get(route('students.show', $student))->assertSee("<dd>{$expectedAge}</dd>", false);
})->with([
    'before birthday' => ['2026-04-11', 25],
    'on birthday' => ['2026-04-12', 26],
    'after birthday' => ['2026-04-13', 26],
]);

test('student age is unavailable when the birthday is missing', function () {
    $student = Student::factory()->withoutOptionalDetails()->create();

    $this->get(route('students.show', $student))->assertSee('<dd>Not available</dd>', false);
});
