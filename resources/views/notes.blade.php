@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Notes') }}</div>

                <div class="card-body">
                    <textarea id="note-input" class="form-control" rows="10" placeholder="Write a note..."></textarea>
                    <button id="save-note" class="btn btn-primary mt-2">Save Note</button>
                    <ul id="notes-list" class="list-group mt-3">
                        <!-- Notes will be dynamically added here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const noteInput = document.getElementById('note-input');
        const saveNoteBtn = document.getElementById('save-note');
        const notesList = document.getElementById('notes-list');
        let notes = JSON.parse(localStorage.getItem('calculator_notes')) || [];

        function renderNotes() {
            notesList.innerHTML = '';
            notes.forEach((note, index) => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `
                    <span>${note}</span>
                    <button class="btn btn-danger btn-sm delete-note" data-index="${index}">Delete</button>
                `;
                notesList.appendChild(li);
            });
        }

        function saveNotes() {
            localStorage.setItem('calculator_notes', JSON.stringify(notes));
        }

        saveNoteBtn.addEventListener('click', () => {
            const noteText = noteInput.value.trim();
            if (noteText) {
                notes.push(noteText);
                noteInput.value = '';
                saveNotes();
                renderNotes();
            }
        });

        notesList.addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-note')) {
                const index = event.target.getAttribute('data-index');
                notes.splice(index, 1);
                saveNotes();
                renderNotes();
            }
        });

        renderNotes();
    });
</script>
@endsection
