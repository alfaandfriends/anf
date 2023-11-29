<x-mail::message>
<!-- # Introduction -->

Dear Parents,



Thank you for taking the time to have your child complete the diagnostic test for our maths class. The results of this test will allow us to better understand your child's current level of understanding in maths and develop a plan to help them reach their full potential.



We understand that maths can be a challenging subject, but we want to assure you that our goal is to make the learning process as enjoyable and engaging as possible for your child. Our team of experienced educators is dedicated to creating a supportive and nurturing environment that will encourage your child to develop their maths skills and improve their confidence.



We believe that with the right guidance and support, every student can excel in maths. As we move forward, we will keep you informed of your child's progress and work together to help them reach their academic goals.



Thank you for your continued support and involvement in your child's education. If you have any questions or concerns, please do not hesitate to reach out to us.

@component('mail::table')
    | Result          | Action          |
    | :------------ | -------------- |
    @foreach ($reports as $report)
        | {{ $report['name'] }} | <div style="text-align: center;"><a href="{{ route('diagnostic_test.report', $report['id'])}}">View</a></div> | 
    @endforeach
@endcomponent
</x-mail::message>
