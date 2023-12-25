@echo off
setlocal enabledelayedexpansion

rem Create an empty array for JSON output

rem Iterate through ARP table entries
for /f "tokens=1-3" %%a in ('arp -a ^| findstr /v /c:"Interface"') do (
    set "ip=%%a"
    set "mac=%%b"
    
    rem Use nslookup to get the device name
    for /f "tokens=2 delims=: " %%c in ('nslookup !ip! ^| find "Name:"') do (
        set "name=%%c"
        set "name=!name: =!"
    )
    rem Exclude the unwanted entry
    if "!ip!" neq "Internet" (
        if "!mac!" neq "Address" (
            set "json=!json!,{"ip":"!ip!","mac":"!mac!","name":"!name!"}"
        )
    )
)

rem Remove the leading comma from the first entry
set "json=[!json:~1!]"

rem Output the JSON array
echo %json%

endlocal
pause