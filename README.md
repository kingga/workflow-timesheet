# Xero Workflow Weekly CSV Export Parser
This small package parses the CSV export function from Xero's Workflow timesheet system into a set of container classes. The format will look something like this:

```
Week: [
    getStart() => DateTime
    getEnd() => DateTime
    getTotalTime() => Float
    getDays() => [
        Day: [
            getDate() => DateTime
            getDayName() => String [Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday]
            getTotalTime() => Float
            getEntries() => [
                Entry: [
                    getClient() => String
                    getJobId() => String
                    getJob() => String
                    getTask() => String
                    getTime() => Float
                ]
            ]
        ]
    ]
]
```

## Installation
Run the command `composer require kingga/workflow`.

## Usage
```php
$parser = new Kingga\Workflow\Parser;
$timesheet = $parser->parse(__DIR__ . '/Time-Sheet.csv');

dd($timesheet);
```

## Testing
Run the command `composer test`.
