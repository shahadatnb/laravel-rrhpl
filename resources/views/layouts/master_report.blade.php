<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Report - {{ trans('language.company_name') }}</title>

        {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"> --}}
        <link href="{{ URL::to('/public/css/bootstrap.css')}}" rel="stylesheet">
        {!! Html::style('public/css/style.css') !!}
        @yield('stylesheet')
    </head>
    <body>
    <div class="container">
    	@include('partials.report_header')
        <table style="width: 100%">
            <tr>
                <td>From: @yield('from')</td>
                <td>To: @php echo date_format(date_create(Session::get('to_date')),'d-M-Y') @endphp</td>
                <td class="text-right">Print Date Time: @php echo date('d-M-Y h:i:s A') @endphp</td>
            </tr>
        </table>
		@yield('report')    	
    </div>
    @yield('scripts')
    </body>
</html>
