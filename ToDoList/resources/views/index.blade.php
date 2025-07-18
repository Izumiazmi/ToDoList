<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Awesome Todo List</title>

  <!-- MDBootstrap 5 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #121212;
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
    }

    .card {
      background-color: #1e1e1e;
      color: #fff;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
    }

    .form-outline input {
      background-color: #2b2b2b;
      border: none;
      color: #fff;
    }

    .form-outline input::placeholder,
    .form-outline label {
      color: #aaa;
    }

    .btn-primary {
      background-color: #2563eb;
      border: none;
    }

    .btn-primary:hover {
      background-color: #1d4ed8;
    }

    .list-group-item {
      background-color: transparent;
      border: none;
      color: #fff;
      border-bottom: 1px solid #333;
    }

    .form-check-input {
      accent-color: #2563eb;
      width: 1.2rem;
      height: 1.2rem;
    }

    s {
      color: #bbb;
    }

    i.fas.fa-times {
      cursor: pointer;
      font-size: 1.2rem;
      transition: color 0.2s ease;
    }

    i.fas.fa-times:hover {
      color: #ef4444;
    }

    .filter-buttons button {
      margin-right: 10px;
    }

    .date-separator {
      font-weight: bold;
      font-size: 1rem;
      margin-top: 1.5rem;
      margin-bottom: 0.5rem;
      border-bottom: 1px solid #444;
      padding-bottom: 4px;
      color: #bbb;
    }

    .todo-text {
      display: block;
      padding-left: 1.8rem;
      text-indent: -1.8rem;
      line-height: 1.4;
    }

    .todo-item:hover .action-buttons {
      display: flex !important;
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
    }


    .modal-content {
      background-color: #1e1e1e;
      color: #fff;
    }

    .modal-header,
    .modal-footer {
      border-color: #444;
    }

    .form-control.bg-dark {
      background-color: #2b2b2b;
      color: #fff;
      border: none;
    }

    .footer {
      background-color: #1e1e1e;
      color: #aaa;
      border-top: 1px solid #333;
      position: relative;
      bottom: 0;
      width: 100%;
      font-size: 0.9rem;
    }

    .footer {
      position: fixed;
      bottom: 0;
    }
  </style>
</head>

<body>

  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-start h-100">
        <div class="col col-xl-10">

          <div class="card">
            <div class="card-body p-5">

              <h4 class="mb-3">Hi Izumi</h4>

              <!-- Input Form -->
              <form action="{{ route('todos.store') }}" method="POST"
                class="d-flex justify-content-center align-items-center mb-4">
                @csrf
                <div data-mdb-input-init class="form-outline flex-fill">
                  <input type="text" name="text" id="form3" class="form-control form-control-lg text-white"
                    placeholder="Kesibukan apa lagi sekarang?" autocomplete="off" />
                </div>
                <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                <button type="submit" class="btn btn-primary btn-lg ms-2">Add</button>
              </form>


              <!-- Filter Buttons -->
              <div class="filter-buttons mb-4 text-center">
                <a href="{{ route('todo.index') }}" class="btn btn-outline-light btn-sm">All</a>
                <a href="{{ route('todo.filter', 'completed') }}" class="btn btn-outline-light btn-sm">Completed</a>
                <a href="{{ route('todo.filter', 'incomplete') }}" class="btn btn-outline-light btn-sm">Malas
                  Ngerjain</a>
              </div>


              <!-- Todo List -->
              @foreach($todos as $date => $items)
            <div class="date-separator">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</div>
            <ul class="list-group mb-3">
            @foreach($items as $todo)
          <li
          class="list-group-item todo-item d-flex justify-content-between align-items-start position-relative">
          <form action="{{ route('todos.update', $todo->id) }}" method="POST"
          class="d-flex align-items-start w-100 todo-form">
          @csrf
          @method('PUT')
          <input class="form-check-input me-2 mt-1 bg-black" type="checkbox" name="is_completed"
            onchange="this.form.submit()" {{ $todo->is_completed ? 'checked' : '' }} />
          <input type="hidden" name="text" value="{{ $todo->text }}">
          <span
            class="todo-text {{ $todo->is_completed ? 'text-decoration-line-through text-muted' : '' }}">{{ $todo->text }}</span>
          </form>

          <div class="action-buttons d-none">
          <button class="btn btn-sm btn-outline-warning btn-edit me-2" data-id="{{ $todo->id }}"
            data-text="{{ $todo->text }}">Edit</button>

          <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
          </form>
          </div>
          </li>
        @endforeach
            </ul>
        @endforeach


            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- MDBootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
  <script>
    document.querySelectorAll('.form-outline').forEach((formOutline) => {
      new mdb.Input(formOutline).init();
    });
  </script>

  <!-- Modal Edit -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" id="editForm">
        @csrf
        @method('PUT')
        <div class="modal-content" style="background-color: #1e1e1e; color: #fff;">
          <div class="modal-header border-bottom" style="border-color: #444;">
            <h5 class="modal-title" id="editModalLabel">Edit Todo</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="text" name="text" id="editText" class="form-control text-white bg-balck"
              style="background-color: #2b2b2b; border: none;" />
          </div>
          <div class="modal-footer border-top" style="border-color: #444;">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.querySelectorAll('.btn-edit').forEach(button => {
      button.addEventListener('click', function () {
        const id = this.dataset.id;
        const text = this.dataset.text;

        const form = document.getElementById('editForm');
        form.action = `/ToDoList/${id}`;
        document.getElementById('editText').value = text;

        const modal = new mdb.Modal(document.getElementById('editModal'));
        modal.show();
      });
    });
  </script>

  <footer class="footer text-center mt-auto py-3">
    <div class="container">
      <span>&copy; {{ date('Y') }} <a href="https://izumiazmi.github.io/portofolio-azmi/" target="_blank" class="footer-link">Izumi</a>. All rights reserved.</span>
    </div>
  </footer>



</body>

</html>