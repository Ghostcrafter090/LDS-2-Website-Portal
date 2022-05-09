pushd "C:\inetpub\lightningdata"
start "" "gitpush.bat"

:loop
py interface.py
goto loop