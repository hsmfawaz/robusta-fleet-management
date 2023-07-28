{{ $datatable->table() }}


@push('modals')
    {{ $datatable->scripts(attributes: ['type' => 'module']) }}
    <script>
        window.helper_trans = {
            title: '{{ __("Are you sure ?") }}',
            body: '{{ __("You wont be able to restore it again") }}',
            confirm: '{{ __("Yes, delete") }}',
            cancel: '{{ __("No, cancel") }}'
        }

        function deleteRow(ts) {
            let url = $(ts).data('href')
            Swal.fire({
                title: window.helper_trans.title,
                text: window.helper_trans.body,
                showCancelButton: true,
                confirmButtonText: window.helper_trans.confirm,
                cancelButtonText: window.helper_trans.cancel,
                timer: undefined
            }).then((isConfirm) => {
                if (isConfirm.value) {
                    $.post(url, {_method: 'DELETE', _token: "{{ csrf_token() }}"}).done(function (response) {
                        if (response.status) {
                            $('.dataTable').DataTable().ajax.reload()
                            Swal.fire({
                                title: '{{__("Good Job")}}',
                                text: response.data,
                                icon: 'success',
                                confirmButtonText: '{{__("OK")}}',
                                showCancelButton: false
                            })
                        } else {
                            Swal.fire('{{__("Failed!")}}', response.message || '{{__("Unexpected error occurred")}}', 'error')
                            console.log(response)
                        }
                    }).fail((error) => {
                        Swal.fire(
                            '{{__("Failed!")}}',
                            error.status === 403 ? '{{__("You are not allowed to delete this row")}}' : '{{__("Cant delete this row")}}',
                            'error'
                        )
                    })
                }
            })
        }
    </script>
@endpush