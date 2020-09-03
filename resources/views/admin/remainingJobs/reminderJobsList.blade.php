<div class="table-responsive scrollbar p-0">
    <table class="en-list table table-borderless table-striped scrollbar">
        <thead>
            <tr>
                <th width="10">

                </th>
                <th>
                    Type
                </th>
                <th>
                    Description
                </th>
                <th>
                    In charge person(s)
                </th>
                <th>
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($reminderJobs as $reminderJob)
                <tr>
                    <td>
                    </td>
                    <td>
                        {{ App\ReminderType::TYPES[$reminderJob->reminderType->type] ?? ""}}
                    </td>
                    <td>
                        {{ $reminderJob->reminderType->description ?? ""}}
                    </td>
                    <td>
                        {{ implode(", ", $reminderJob->inCharges()->pluck('name')->toArray())}}
                    </td>
                    <td>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>