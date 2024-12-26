@extends('layouts.main.app')

@section('content')
    <div class="row" style="padding: 0px; margin: 0px;">
        <div class="container d-flex h-100vh">
            <div class="col-sm-12 col-md-8 col-lg-8 mx-auto my-auto">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-12 col-md-7">
                            <img class="img-fluid" src="{{ asset('img/app_install.svg') }}" alt="app_install">
                        </div>
                        <div class="col-12 col-md-5 pt-2 pt-md-5">
                            <h5 class="text-muted"><span
                                    class="text-primary font-weight-bold">{{ config('app.name') }}</span> is now available
                                on mobile phone devices <i class="fas fa-mobile-alt ml-1"></i></h6>
                                <br>
                                <!-- Install button, hidden by default -->
                                <div id="installContainer" class="hidden">
                                    <button class="btn btn-sm btn-primary form-control" id="butInstall">Install
                                        Application</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Initialize deferredPrompt for use later to show browser install prompt.
        let deferredPrompt;
        const divInstall = document.getElementById('installContainer');
        const butInstall = document.getElementById('butInstall');
        window.addEventListener('beforeinstallprompt', (event) => {
            // Prevent the mini-infobar from appearing on mobile.
            event.preventDefault();
            //console.log('👍', 'beforeinstallprompt', event);
            // Stash the event so it can be triggered later.
            window.deferredPrompt = event;
            // Remove the 'hidden' class from the install button container.
            divInstall.classList.toggle('hidden', false);
        });
        butInstall.addEventListener('click', async () => {
            //console.log('👍', 'butInstall-clicked');
            const promptEvent = window.deferredPrompt;
            if (!promptEvent) {
                // The deferred prompt isn't available.
                return;
            }
            // Show the install prompt.
            promptEvent.prompt();
            // Log the result
            const result = await promptEvent.userChoice;
            // console.log('👍', 'userChoice', result);
            // Reset the deferred prompt variable, since
            // prompt() can only be called once.
            window.deferredPrompt = null;
            // Hide the install button.
            divInstall.classList.toggle('hidden', true);
        });
        window.addEventListener('appinstalled', (event) => {
            console.log('👍', 'appinstalled', event);
            // Clear the deferredPrompt so it can be garbage collected
            window.deferredPrompt = null;
            location.href = window.location.origin + "/login"
        });
    </script>
@endsection
