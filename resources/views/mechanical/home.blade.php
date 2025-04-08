@extends('layouts.mechanical_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Mechanical Dashboard</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            //initial call
            alart_message();
        });

        //start alart massage
        function alart_message() {
            $.ajax({
                url: "{{ route('alart_massage') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        for (i = 0; i < data.length; i++) {
                            var setTime = i * 1000;
                            var massage = '<a href="'+data[i].link+'" class="'+data[i].color+'">'+data[i].massage+'</a>';
                            notify(massage, setTime);
                        }
                    }
                }
            });
        }

        // 1 second delayed push massage
        function notify(data, setTime) {
            var myToast = new Toasty({
                sounds: {
                    // path to sound for informational message:
                    info: "{{ asset('public') }}/toasty_js/dist/sounds/info/1.mp3",
                    // path to sound for successfull message:
                    success: "{{ asset('public') }}/toasty_js/dist/sounds/success/1.mp3",
                    // path to sound for warn message:
                    warning: "{{ asset('public') }}/toasty_js/dist/sounds/warning/1.mp3",
                    // path to sound for error message:
                    error: "{{ asset('public') }}/toasty_js/dist/sounds/error/1.mp3",
                },
            });
            setTimeout(() => {
                myToast.success(data);
            }, setTime);

        }
        //End Alart massage
    </script>
@endsection
