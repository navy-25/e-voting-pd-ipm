@ECHO OFF
SET PHP=C:\Xampp\php\.\php.exe
SET BEAUTIFY=C:\Xampp\php\php_beautifier
%PHP% -d output_buffering=1 -f %BEAUTIFY% -- %1 %2 %3 %4 %5 %6 %7 %8 %9
@ECHO ON
