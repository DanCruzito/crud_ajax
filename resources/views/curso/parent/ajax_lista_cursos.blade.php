<table class="table" id="tabla_cursos">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre del curso</th>
            <th scope="col">Descripción</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cursos as $index => $row)
            <tr>
                <th scope="row">{{ $index + 1}}</th>
                <td>{{ $row->nombre_curso }}</td>
                <td>{{ $row->descripcion }}</td>
                <td><div class="d-grid gap-2 d-md-block">
                    <button class="btn btn-success btn_editar_curso" data-id-curso="{{ $row->id }}" type="button">Editar</button>
                    <button class="btn btn-danger btn_eliminar_curso" data-id-curso="{{ $row->id }}" type="button">Eliminar</button>
                  </div>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
