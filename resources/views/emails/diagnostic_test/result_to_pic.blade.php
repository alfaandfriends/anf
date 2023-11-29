<x-mail::message>
<!-- # Introduction -->

Dear **{{ $info['pic_name'] }}**,


**{{ $info['student_name'] }}** (**{{ $info['student_age'] }}**) has successfully completed the diagnostic test for **{{ $info['dt_title'] }}**. The test was administered on **{{ $info['test_date'] }}** and the results have been recorded.


It has been reviewed and certain areas have been identified where **{{ $info['student_name'] }}** may need additional support and guidance.

@component('mail::table')
    | Result          | Action          |
    | :------------ | -------------- |
    @foreach ($info['reports'] as $report)
        | {{ $report['name'] }} | <div style="text-align: center;"><a href="{{ route('diagnostic_test.report', $report['id'])}}">View</a></div> | 
    @endforeach
@endcomponent
</x-mail::message>
