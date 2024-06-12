@php
    $usercompanies = session('usercompanies', collect());
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('./styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css"
        integrity="sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <title>dashboard</title>
</head>

<body id="body">
    <x-header />

    <div class="my_account_box">
        <span>
            My account
        </span>
    </div>
    <div class="main_dashboard">
        <x-dashboard.side_nav_bar />

        <div class="dasghboard_content">
            <x-dashboard.company_orders :companyorders="$companyorders"/>
            {{-- <x-dashboard.companyorder :usercompanies="$usercompanies" /> --}}
        </div>

    </div>
    <x-footer />
    <x-utilis.script />
</body>

</html>
