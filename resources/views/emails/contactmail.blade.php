
@component('mail::message')
# Introduction

The body of your message. <br>
You received an email from : {{$array['name']}}

@component('mail::table')
|          |           |
|:------:  |:---------:|
|Name|{{$array['name']}}|
|Email |{{$array['email']}}|
|Subject |{{$array['subject']}}|
|Message |{{$array['message']}}|
|          |           |
|:------:  |:---------:|
@endcomponent




Thanks,<br>
Taxdocs
@endcomponent
