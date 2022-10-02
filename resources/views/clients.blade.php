@extends('layouts.app')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

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
                                    <li class="breadcrumb-item active"><a href="javascript: void(0);">Clients</a></li>
                                </ol>
                            </div>
                            <h4 class="page-title">Clients</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-5">
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="text-sm-end">
                                            <div class="btn-group mb-2">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success  me-1 dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false"> Télécharger <span
                                                            class="caret"></span> </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('download', 'csv') }}">Format
                                                            CSV</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('download', 'xlsxs') }}">Format XLSX</a>

                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#params_modal"> Champs à
                                                            Récupérer</a>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#birth_date_filter"> Date de Naissance</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col-->
                                    </div>

                                    <div class="table-responsive">
                                        <table
                                            class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap"
                                            id="products-datatable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 20px;">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck1">
                                                            <label class="form-check-label"
                                                                for="customCheck1">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th>Prénom</th>
                                                    <th>Nom</th>
                                                    <th>Téléphone</th>
                                                    <th>Date de naissance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($clients as $client)
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="customCheck2">
                                                                <label class="form-check-label"
                                                                    for="customCheck2">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td class="table-user">
                                                            {{ $client->first_name }}
                                                        </td>
                                                        <td>
                                                            {{ $client->last_name }}

                                                        </td>
                                                        <td>
                                                            {{ $client->phone_number }}

                                                        </td>
                                                        <td>
                                                            {{ date('d-m-Y', strtotime($client->birth_date)) }}

                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        No Data
                                                    </tr>
                                                @endforelse


                                            </tbody>
                                        </table>
                                        {{ $clients->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                                <!-- end card-body-->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                </div>
                <!-- container -->

            </div>
            <!-- content -->



        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>

    <div id="params_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="params_modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="params_modalLabel">Champs à
                        Récupérer</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <p>Sélectionnez le(s) champs que vous souhaitez récupérer ci-dessous</p>
                    <hr>
                    <form action="{{ route('get_by_param') }}" method="get">
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" name="params[1]" value="last_name"
                                id="last_name" checked>
                            <label class="form-check-label" for="last_name">Nom</label>
                        </div>
                        <div class="form-check form-checkbox-success mb-2">
                            <input type="checkbox" class="form-check-input" value="first_name" name="params[2]"
                                id="first_name" checked>
                            <label class="form-check-label" for="first_name">Prénom</label>
                        </div>
                        <div class="form-check form-checkbox-info mb-2">
                            <input type="checkbox" class="form-check-input" value="phone_number" name="params[3]"
                                id="phone_number" checked>
                            <label class="form-check-label" for="phone_number">Téléphone</label>
                        </div>
                        <div class="form-check form-checkbox-secondary mb-2">
                            <input type="checkbox" class="form-check-input " value="birth_date" name="params[4]"
                                id="birth_date" checked>
                            <label class="form-check-label" for="birth_date">Date de naissance
                            </label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Télécharger</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="birth_date_filter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="birth_date_filterLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="birth_date_filterLabel">Filtre sur la Date de Naissance</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <p>Indiquez les deux dates entre lesquelles sont nés les clients ou la date exacte</p>
                    <hr>
                    <form action="{{ route("where_birth_date_between") }}" method="get">
                        <div class="mb-3">
                            <label for="example-date" class="form-label">Entre</label>
                            <input class="form-control" id="example-date" type="date" name="date[1]" required>
                        </div>
                        <div class="mb-3">
                            <label for="example-date" class="form-label">Et Entre</label>
                            <input class="form-control" id="example-date" type="date" name="date[2]" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Télécharger</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END wrapper -->
@endsection
