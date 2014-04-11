## Ansibles - MySQL [![Build Status](https://travis-ci.org/Ansibles/mysql.png)](https://travis-ci.org/Ansibles/mysql)

Ansible role that installs MySQL on (for now) Ubuntu variants.
Features include:
- Installation of MySQL and it's dependencies
- Basic configuration
- Standard hardening (root password, removal of test databases)
- Add databases
- Add users
- Setup of monit process supervision


#### Requirements & Dependencies
- Tested on Ansible 1.4 or higher.
- Ansibles.monit if you want monit protection (in that case, you should set `monit_protection: true`)


#### Variables

```yaml
# Basic settings
mysql_port: 3306                        # The port on which mysql listens
mysql_bind_address: "0.0.0.0"           # The address the mysql server binds on
mysql_root_password: 'pass'             # The root password

# Fine Tuning
mysql_key_buffer: '16M'
mysql_max_allowed_packet: '128M'
mysql_thread_stack: '192K'
mysql_cache_size: 8
mysql_myisam_recover: 'BACKUP'
mysql_max_connections: 100
mysql_table_cache: 64
mysql_thread_concurrency: 10
mysql_query_cache_limit: '1M'
mysql_query_cache_size: '16M'
mysql_innodb_file_per_table: 'innodb_file_per_table'
mysql_character_set_server: 'utf8'
mysql_collation_server: 'utf8_general_ci'
mysql_mysqldump_max_allowed_packet: '128M'
mysql_isamchk_key_buffer: '16M'

# List of databases to be created (optional)
mysql_databases:
  - name: foobar

# List of users to be created (optional)
mysql_users:
  - name: baz
    pass: pass
    priv: "*.*:ALL"

# GLOBAL Setting
monit_protection: false                 # true or false, requires Ansibles.monit
```


#### License

Licensed under the MIT License. See the LICENSE file for details.


#### Feedback, bug-reports, requests, ...

Are [welcome](https://github.com/ansibles/mysql/issues)!
