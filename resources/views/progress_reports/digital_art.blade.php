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
            <td><img src="{{ public_path('/images/progress_report/digital_art.png') }}" style="width: 100%; height: 200px"/></td>
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
            $groupedData = collect($report_item)->groupBy(['theme_name', 'lesson_name', 'activity_name', 'outcome_name']);

            $filteredData = $groupedData->map(function($themes) {
                return $themes->map(function($lessons) {
                    return $lessons->map(function($activities) {
                        return $activities->map(function($outcome) {
                            return [
                                'objectives' => $outcome[0]['objectives'] ?? [],
                            ];
                        });
                    });
                });
            });
        @endphp
        <table width="100%" style="margin-top: 20px; page-break-inside: auto; border-top: 2px solid; border-bottom: 2px solid; border-left: 2px solid; border-right: 2px solid;">
            <tbody>
                <tr>
                    <th width="40%" style="background-color: #A0C49D; border: 1px solid; padding: 10px; font-size: 12px">Date</th>
                    <th width="60%" style="background-color: #A0C49D; border: 1px solid; padding: 10px; font-size: 12px" colspan="2">
                        <div>
                            {{ date("d-m-Y", strtotime($report->date)) }} ({{ $report->attendance_status_name }}) 
                        </div>
                        <div>
                            
                        </div>
                    </th>
                </tr>
                @foreach($filteredData as $theme_name => $lessons)
                    <tr>
                        <th style="background-color: #C4D7B2; border: 1px solid; padding: 10px; font-size: 12px">Theme</th>
                        <th style="background-color: #C4D7B2; border: 1px solid; padding: 10px; font-size: 12px" colspan="2">
                            <div>
                                {{ $theme_name }}
                            </div>
                        </th>
                    </tr>
                    @foreach($lessons as $lesson_name => $activities)
                        @foreach($activities as $activity_name => $outcomes)
                            <tr>
                                <th style="text-align: left; background-color: #E1ECC8; border: 1px solid; padding: 10px; font-size: 12px; text-decoration: underline;" colspan="3">{{ $lesson_name }} : {{ $activity_name }}</th>
                            </tr>
                            @foreach($outcomes as $outcome_name => $objectives)
                                <tr>
                                    <td style="border: 1px solid; padding: 10px;">
                                        <div style="font-weight: bold"><b>{{ $outcome_name }}</b></div>
                                    </td>
                                    <td valign="top" style="text-align: justify; border: 1px solid; padding: 10px;" colspan="2">
                                        @foreach($objectives['objectives'] as $key => $objective)
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
                @endforeach
                @if($report->comments)
                    <tr>
                        <th width="15%" style="text-align: left; background-color: #F7FFE5; border: 1px solid; padding: 10px; font-size: 12px" colspan="3">COMMENT</th>
                    </tr>
                    <tr>
                        <td width="15%" style="border: 1px solid; padding: 10px; font-size: 12px" colspan="3">
                            <div>
                                <i>{!! nl2br($report->comments) !!}</i>
                            </div>
                        </td>
                    </tr>
                @endif
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