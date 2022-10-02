@extends('layouts.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Telemaque</a></li>
                                    <li class="breadcrumb-item active">Compression et Décompression </li>
                                </ol>
                            </div>
                            <h4 class="page-title">Telemaque</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Compression </h4>
                                <p class="text-muted font-14"> faire une réduction de lettres</p>
                                <div class="tab-content">
                                    <form action="{{ route('compression') }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="subject_compression" class="form-label">Texte</label>
                                            <input type="text" id="subject_compression" name="subject" required
                                                class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Envoyer</button>
                                    </form>
                                </div> <!-- end tab-content-->
                            </div> <!-- end card-body -->
                        </div> <!-- end card-->

                    </div> <!-- end col -->

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Décompression </h4>
                                <p class="text-muted font-14"> décompresser une réduction de lettres</p>
                                <div class="tab-content">
                                    <form action="{{ route("decompression") }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="subject_decompression" class="form-label">Texte</label>
                                            <input type="text" id="subject_decompression" name="subject" required
                                                class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Envoyer</button>
                                    </form>
                                </div> <!-- end tab-content-->
                            </div> <!-- end card-body -->
                        </div> <!-- end card-->

                    </div> <!-- end col -->
                </div>
                @if (session('message'))
                    <div class="alert alert-success">
                        <p>{{ session('message') }}</p>
                    </div>
                @endif


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- end row -->

            </div> <!-- container -->

        </div> <!-- content -->

    </div>
@endsection
