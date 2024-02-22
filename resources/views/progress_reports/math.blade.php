<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Progress Report</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    .page-break {
        page-break-after: always;
    }
    table{
        font-size: x-small;
        border-collapse: collapse; 
        width: 100%;
        table-layout: fixed;
    }
</style>
</head>
<body>
    <table width="100%">
        <tr>
            <td><img src="{{ public_path('/images/progress_report/math.png') }}" style="width: 100%; height: 200px"/></td>
        </tr>
    </table>
    <table width="100%" style="padding-top: 20px; padding-bottom: 20px">
        <tr>
            <td style="text-align: center;"><strong style="font-size: 20px">Monthly Progress Report</strong></td>
        </tr>
    </table>
    <div style="padding-top: 10px; padding-bottom: 10px; padding-left: 35px; padding-right: 35px; border: 2px solid">
        <table width="100%">
            <tr>
                <td style="font-size: 13px; padding: 10px">Student's Name: </td>
                <td style="font-size: 13px; padding: 10px">{{ $data['student_data']->student_name }}</td>
            </tr>
            <tr>
                <td style="font-size: 13px; border-top: 1px solid gray; border-bottom: 1px solid gray; padding: 10px">Date Joined: </td>
                <td style="font-size: 13px; border-top: 1px solid gray; border-bottom: 1px solid gray; padding: 10px">{{ $data['student_data']->date_joined }}</td>
            </tr>
            <tr>
                <td style="font-size: 13px; padding: 10px">Class Type / level: </td>
                <td style="font-size: 13px; padding: 10px">{{ $data['student_data']->programme_name }} / Level {{ $data['student_data']->programme_level }}</td>
            </tr>   
        </table>
    </div>
    @foreach($data['report_data'] as $key => $report)
        @php
            $report_item = json_decode($report->report_data, true);
            $groupedData = collect($report_item)->groupBy(['term_book_name', 'unit_name', 'lesson_name']);

            $filteredData = $groupedData->map(function($terms_books) {
                return $terms_books->map(function ($units) {
                    return $units->map(function ($lessons) {
                        return [
                            'objectives' => $lessons[0]['objectives'] ?? [],
                        ];
                    });
                });
            });
        @endphp
        <table width="100%" style="margin-top: 20px; page-break-inside: auto">
            <tbody>
                <tr>
                    <th width="40%" style="background-color: #A0C49D; border: 2px solid; padding: 10px; font-size: 12px">Date</th>
                    <th width="60%" style="background-color: #A0C49D; border: 2px solid; padding: 10px; font-size: 12px" colspan="2">
                        <div>
                            {{ date("d-m-Y", strtotime($report->date)) }} ({{ $report->attendance_status_name }}) 
                        </div>
                        <div>
                            
                        </div>
                    </th>
                </tr>
                @foreach($filteredData as $term_book_name => $term_book)
                    <tr>
                        <th style="background-color: #C4D7B2; border: 2px solid; padding: 10px; font-size: 12px">Term / Book</th>
                        <th style="background-color: #C4D7B2; border: 2px solid; padding: 10px; font-size: 12px" colspan="2">
                            <div>
                                {{ $term_book_name }}
                            </div>
                        </th>
                    </tr>
                    @foreach($term_book as $unit_name => $unit)
                        <tr>
                            <th style="background-color: #E1ECC8; border: 2px solid; padding: 10px; font-size: 12px; text-decoration: underline;" colspan="3">Unit {{ $unit_name }}</th>
                        </tr>
                        @foreach($unit as $lesson_name => $lesson)
                            <tr>
                                <td style="border: 2px solid; padding: 10px;">
                                    <div style="font-weight: bold;"><b>Lesson {{ $lesson_name }}</b></div>
                                </td>
                                <td valign="top" style="text-align: justify; border: 2px solid; padding: 10px;" colspan="2">
                                    @foreach($lesson['objectives'] as $key => $objective)
                                        <div style="display: block;">
                                            <div style="display: inline-block; vertical-align: middle; line-height: 20px; ">
                                                @if($objective['achieved'])
                                                    <img src="{{ public_path('/images/progress_report/circle-check.svg') }}" width="15px"/>
                                                @else
                                                    <img src="{{ public_path('/images/progress_report/circle-cross.svg') }}" width="15px"/>
                                                @endif
                                                {{ $objective['name'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
                <tr>
                    <th width="15%" style="text-align: left; background-color: #F7FFE5; border: 2px solid; padding: 10px; font-size: 12px" colspan="3">COMMENT</th>
                </tr>
                <tr>
                    <td width="15%" style="border: 2px solid; padding: 10px; font-size: 12px" colspan="3">
                        <div>
                            <i>{!! nl2br($report->comments) !!}</i>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
    <div style="margin-top: 30px;">
        <table> 
            <tr>
                <th width="15%" style="text-align: left; background-color: #A0C49D; border: 2px solid; padding: 10px; font-size: 12px" colspan="3">WHAT'S NEXT</th>
            </tr>
            <tr>
                <td width="15%" style="border: 2px solid; padding: 10px; font-size: 12px" colspan="3">
                    <div>
                        {{ $data['student_data']->upcoming_feedback }}
                    </div>
                </td>
            </tr>
            <tr>
                <th width="15%" style="text-align: left; background-color: #A0C49D; border: 2px solid; padding: 10px; font-size: 12px" colspan="3">NEED IMPROVEMENT ON</th>
            </tr>
            <tr>
                <td width="15%" style="border: 2px solid; padding: 10px; font-size: 12px" colspan="3">
                    <div>
                        {{ $data['student_data']->improvement_feedback }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>