# LogBook Symfony Bundle

LogBook is a centralized web log viewer for monolog logs files. 
It allows you to list and view logs from local and external project, in one easy place with highlighting and level and channel filtering.

## Installation
Install the package with:
```console
composer require johnnestebann/logbook-symfony-bundle
```
##  Configuration

Create the routes yaml file `config/routes/evo_log_viewer_routes.yaml`

```yaml
evo_log_viewer:
  resource: '@EvotodiLogViewerBundle/Resources/config/routes.xml'
  prefix: '/logs'
```
Create the config yaml file `config/packages/evo_log_viewer.yaml`
```yaml
# List of log files to show
evo_log_viewer:
    log_files:
        # Unique identifier for the logfile
        somelog1:
            # Use full path
            path: 'Some/Full/Path/to/Log/File.Ext'

            # Pretty name to display else file name
            name: My Log Files Pretty Name 

            # (Optional) Number of days to pull from log. See ddtraceweb/monolog-parser.
            days: 0

            # (Optional) See ddtraceweb/monolog-parser for patterns.
            pattern: null

            # (Optional) PHP style date format of log file
            date_format: 'Y-m-d H:i:s'
            
            # (Optional) Log level spelling. Case sensitive
            levels:
                debug: DEBUG
                info: INFO
                notice: NOTICE
                warning: WARNING
                error: ERROR
                alert: ALERT
                critical: CRITICAL
                emergency: EMERGENCY

        somelog2:
            path: '/path/to/logfile.log'
            name: Pretty Logfile Name

    # Show App logs in var/log
    show_app_logs: true
```
## Advanced Configuration

#### pattern
The default pattern is `'/\[(?P<date>.*)\] (?P<logger>\w+).(?P<level>\w+): (?P<message>[^\[\{].*[\]\}])/'`
\
You can change the regex pattern to match your log file but the pattern must include `P<date>`, `P<logger>`, `P<level>`, and `P<message>` as regex groups.
\
Example `'/\[(?P<date>.+)\] (?P<logger>\w+).(?P<level>\w+): (?P<message>.*)/'`
\
See ddtraceweb/monolog-parser for other examples but ommit `P<context>` and `P<extra>`

#### days
Setting days in the config to 0 will parse to whole log which is the default. Days set to 5 for example will parse the log until the date portion of the pattern
if greater than DateTime('now') minus 5 days.

#### date_format
This should be the php date format of the date portion of the pattern. Default is Y-m-d H:i:s
/
[PHP DateFormat](https://www.php.net/manual/en/function.date.php)

#### levels
Override the default spelling for each level. e.g. WARNING -> WARN

## Thanks
Thanks to ddtraceweb/monolog-parser and greenskies/web-log-viewer-bundle.

## Contributions
Contributions are very welcome! 

Please create detailed issues and PRs.  

## License

This package is free software distributed under the terms of the [MIT license](LICENSE).