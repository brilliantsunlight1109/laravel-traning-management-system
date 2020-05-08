<?php

namespace Tests\Unit;

use App\File;
use App\Http\Controllers\FileController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUnitTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    private $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new FileController();
    }

    protected function tearDown(): void
    {
        Storage::deleteDirectory('public/');
        parent::tearDown();
    }

    /** @test */
    public function file_can_be_saved_with_autogenerated_filename()
    {
        $file = UploadedFile::fake()->image('image_test');
        $id = FileController::saveFile($file);

        $modelFile = File::find($id);

        $this->assertNotNull($modelFile);
        $this->assertDatabaseHas('files', ['id' => $id]);
        $this->assertFileNotExists(Storage::path('public/files/' . $file->getClientOriginalName()));
        $this->assertFileExists(Storage::path('public/files/' . $modelFile->path));
    }

    /** @test */
    public function file_can_be_saved_with_fixed_filename()
    {
        $file = UploadedFile::fake()->image('image_test');
        $filename = 'test_image_filename';
        $id = FileController::saveFile($file, $filename);

        $modelFile = File::find($id);

        $this->assertNotNull($modelFile);
        $this->assertDatabaseHas('files', ['id' => $id, 'path' => $filename . ".{$file->getExtension()}"]);
        $this->assertFileExists(Storage::path('public/files/' . $filename . ".{$file->getExtension()}"));
    }


}
