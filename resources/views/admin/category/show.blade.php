@extends('layouts.admin.app')

@section('title', 'Admin | Campus Info')

@section('content')

    {{-- CONTAINER --}}
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2 class="text-center mb-5">
                    <a class="float-left btn btn-sm btn-warning text-smallest" href="{{ route('admin.campuses.index') }}"><i
                            class="fas fa-chevron-left"></i> Back
                    </a>
                </h2>
                <div class="row mt-3 justify-content-center text-center">
                    <div class="col-md-12">
                        <div class="card card-body">
                            <img class="d-block mx-auto rounded-circle" src="{{ asset('img/logo/logo2.png') }}"
                                width="150" alt=""><br>
                            <h3>{{ $campus->name }}</h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-body">
                            <h3>Departments</h3>

                            <ul class="list-group list-group-flush">
                                @forelse ($campus->departments as $department)
                                    <li class="list-group-item">{{ $department->name }}</li>
                                @empty
                                    <li class="list-group-item">Record Not Found</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-body">
                            <div id="map">
                                {{-- display Map --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection
@section('script')

    <script defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUD4TG-JmD1g1tXepWmE8nouXKXKuNVNM&libraries=places&callback=initMap">
    </script>
    <script>
        let campus = {!! $campus !!};
        let lat = parseFloat(campus.latitude);
        let lng = parseFloat(campus.longitude);

        function initMap() {
            let map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat,
                    lng
                },
                zoom: 17, // street view
            });

            addMarker({
                campus,
                position: {
                    lat,
                    lng
                },
                icon: '/img/marker/destination.png'
            }, map)

        }


        function addMarker(config, map) {
            // initialize marker
            const marker = new google.maps.Marker({
                position: config.position,
                animation: google.maps.Animation.DROP,
                map,
                icon: config.icon ?? null,
            });

            if (config.campus !== undefined) {
                const infoWindow = new google.maps.InfoWindow({
                    content: `<h4 class='font-weight-bold'>${config.campus.name}</h4>`,
                });

                marker.addListener("click", () => {
                    infoWindow.open(marker.getMap(), marker);
                });
            }
        }

        window.initMap = initMap;

        $('#faculty_nav').addClass('active')
        $('#campus').addClass('text-primary')
    </script>

@endsection
