<a href="https://travis-ci.org/catalyst/moodle-auth_outage">
<img src="https://travis-ci.org/catalyst/moodle-auth_outage.svg?branch=master">
</a>

# Moodle Outage manager plugin

* [What is this?](#what-is-this)
* [Why is it an auth plugin](#why-it-is-an-auth-plugin)
* [Installation](#installation)
* [Feedback and issues](#feedback-and-issues)

What is this?
-------------

This is a Moodle plugin which makes the student experience of planned outages nicer,
and provides extra tools for administrators and testers that help before and after the
outage window.

The main idea is that instead of an outage being a very booleon on/off situation,
this plugin creates the concept of graduated outages where at predefined times before
an outage and after, different levels of warning and access can be provided to students
and testers letting them know what is about to happen and why.


Screenshots
-----------

![Manage outages page with a scheduled outage warning.](docs/2016-09-28_screenshot_warning.png?raw=true)
Manage outages page with a scheduled outage warning.

![The warning bar during an ongoing outage.](docs/2016-09-28_screenshot_ongoing.png?raw=true)
The warning bar during an ongoing outage.

![The warning bar once the outage has ended.](docs/2016-09-28_screenshot_ended.png?raw=true)
The warning bar once the outage has ended.

Installation
------------

1. Install the plugin the same as any standard moodle plugin either via the
Moodle plugin directory, or you can use git to clone it into your source:

     ```git clone git@github.com:catalyst/moodle-auth_outage.git auth/basic```

    Or install via the Moodle plugin directory:
    
     https://moodle.org/plugins/auth_outage

2. Then run the Moodle upgrade

If you have issues please log them in github here:

https://github.com/catalyst/moodle-auth_outage/issues

3. Go to `Dashboard ► Site administration ► Plugins ► Authentication ► Manage authentication`,
enable the `Outage manager` plugin and place it on the top.


How to use
----------

1. Go to `Dashboard ► Site administration ► Plugins ► Authentication ► Outage manager ► Manage` and set up your future outages.

2. *(optional)* Integrate your maintenance scripts using the CLI in `auth/outage/cli`.

Example of CLI usage:
```
$ php cli/create.php --help
Creates a new outage.

  -h,  --help               shows parameters help.
  -c,  --clone              clone another outage except for the start time.
  -a,  --autostart          must be Y or N, sets if the outage automatically triggers maintenance mode.
  -w,  --warn               how many seconds before it starts to display a warning.
  -s,  --start              in how many seconds should this outage start. Required.
  -d,  --duration           how many seconds should the outage last.
  -t,  --title              the title of the outage.
  -e,  --description        the description of the outage.
       --onlyid             only outputs the new outage id, useful for scripts.
  -b,  --block              blocks until outage starts.
```

Why it is an auth plugin?
-------------------------

One of the graduated stages this plugin introduces is a 'tester only' mode which disables login for most normal users. This is conceptually similar to the maintenance mode but enables testers to login and confirm the state after an upgrade without needing full admin privileges. 


Feedback and issues
-------------------

Please raise any issues in github:

https://github.com/catalyst/moodle-auth_outage/issues

Pull requests are welcome :)

If you need anything urgently or would like to sponsor a feature please contact Catalyst IT Australia:

https://www.catalyst-au.net/contact-us
