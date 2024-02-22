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
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
    table th .border{
        border-left: 0.01em solid #ccc;
        border-right: 0;
        border-top: 0.01em solid #ccc;
        border-bottom: 0;
        border-collapse: collapse;
    }
</style>

</head>
<body>

    <table width="100%">
        <tr>
            <td><img src="{{ public_path('/images/progress_report/coding_robotic.png') }}" style="width: 100%; height: 200px"/></td>
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
            $groupedData = collect($report_item)->groupBy(['lesson_name', 'topic_name', 'objective_name']);

            $filteredData = $groupedData->map(function($lessons) {
                return $lessons->map(function($topics) {
                    return $topics->map(function($objectives) {
                        return [
                            'objectives' => $objectives[0]['activities_procedures'] ?? [],
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
            @foreach($filteredData as $lesson_name => $topics)
                @foreach($topics as $topic_name => $objectives)
                    @foreach($objectives as $objective_name => $activities_procedures)
                        <tr>
                            <th style="text-align: left; background-color: #E1ECC8; border: 2px solid; padding: 10px; font-size: 12px" colspan="3">
                                <div style="margin-bottom: 5px; text-decoration: underline">{{ $lesson_name }} : {{ $topic_name }}</div>
                                <div>{{ $objective_name }}</div>
                            </th>
                        </tr>
                        <!-- <tr>
                            <td style="border: 2px solid; padding: 10px;">
                                <div style="font-weight: bold"><b>{{ $objective_name }}</b></div>
                            </td>
                            <td valign="top" style="text-align: justify; border: 2px solid; padding: 10px;" colspan="2">
                                @foreach($activities_procedures['objectives'] as $key => $objective)
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
                        </tr> -->
                    @endforeach
                @endforeach
            @endforeach
            <tr>
                <th width="15%" style="background-color: #F7FFE5; border: 2px solid; padding: 10px; font-size: 12px">Comment</th>
                <td width="15%" style="background-color: #F7FFE5; border: 2px solid; padding: 10px; font-size: 12px" colspan="2">
                    <div>
                        <i>{!! nl2br($report->comments) !!}</i>
                    </div>
                    <div>
                        
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    @endforeach
    <div style="margin-top: 30px;">
        <table style="width: 100%"> 
            <tr>
                <th style="text-align: left; background-color: #A0C49D; border: 2px solid; padding: 10px; font-size: 12px">WHAT'S NEXT</th>
            </tr>
            <tr>
                <td width="100%" style="border: 2px solid; padding: 10px; font-size: 12px">
                    <div>
                        {{ $data['student_data']->upcoming_feedback }}
                    </div>
                </td>
            </tr>
            <tr>
                <th width="100%" style="text-align: left; background-color: #A0C49D; border: 2px solid; padding: 10px; font-size: 12px">NEED IMPROVEMENT ON</th>
            </tr>
            <tr>
                <td width="100%" style="border: 2px solid; padding: 10px; font-size: 12px">
                    <div>
                        {{ $data['student_data']->improvement_feedback }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>