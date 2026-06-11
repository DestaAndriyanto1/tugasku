<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_view_task_list(): void
    {
        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }

    public function test_can_create_task(): void
    {
        $response = $this->post('/tasks', [
            'title' => 'Belajar Laravel',
            'due_date' => '2026-12-31'
        ]);
    
        $this->assertDatabaseHas('tasks', [
            'title' => 'Belajar Laravel'
        ]);
    
        $response->assertStatus(302);
    }

    public function test_can_complete_task(): void
    {
        $task = \App\Models\Task::create([
            'title' => 'Belajar Laravel',
            'due_date' => '2026-12-31'
        ]);
    
        $response = $this->patch("/tasks/{$task->id}/complete");
    
        $response->assertStatus(302);
    
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => true
        ]);
    }

    public function test_can_update_uncompleted_task(): void
    {
        $task = \App\Models\Task::create([
            'title' => 'Tugas Lama',
            'due_date' => '2026-12-31'
        ]);
    
        $response = $this->patch("/tasks/{$task->id}", [
            'title' => 'Tugas Baru',
            'due_date' => '2026-11-01'
        ]);
    
        $response->assertStatus(302);
    
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Tugas Baru'
        ]);
    }

    public function test_can_delete_uncompleted_task(): void
    {
        $task = \App\Models\Task::create([
            'title' => 'Tugas Hapus',
            'due_date' => '2026-12-31'
        ]);
    
        $response = $this->delete("/tasks/{$task->id}");
    
        $response->assertStatus(302);
    
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

    public function test_can_view_completed_tasks_in_date_range(): void
    {
        \App\Models\Task::create([
            'title' => 'Task 1',
            'due_date' => '2026-12-31',
            'completed' => true,
            'completed_at' => '2026-01-10'
        ]);
    
        $response = $this->get(
            '/tasks/completed?start=2026-01-01&end=2026-01-31'
        );
    
        $response->assertStatus(200);
    
        $response->assertSee('Task 1');
    }

    public function test_can_view_task_report_by_due_date(): void
    {
        \App\Models\Task::create([
            'title' => 'Task A',
            'due_date' => '2026-12-01'
        ]);
    
        \App\Models\Task::create([
            'title' => 'Task B',
            'due_date' => '2026-12-01'
        ]);
    
        \App\Models\Task::create([
            'title' => 'Task C',
            'due_date' => '2026-12-02'
        ]);
    
        $response = $this->get('/tasks/report');
    
        $response->assertStatus(200);
    
        $response->assertSee('2026-12-01');
        $response->assertSee('2');
    
        $response->assertSee('2026-12-02');
        $response->assertSee('1');
    }
}