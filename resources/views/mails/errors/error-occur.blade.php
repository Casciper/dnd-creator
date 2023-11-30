@extends('mails.layout')
@section('content')
    <body>
        <table class="body-wrap">
            <tr>
                <td class="container">
                    <!-- Message start -->
                    <table>
                        <tr>
                        </tr>
                        <tr>
                            <td class="content">
                                <h2 class="title">Здравствуйте!</h2>
                                <p>Ссылка: <a href="">{{ $url ?? 'неизвестно' }}</a></p>
                                <p>
                                    ОШИБКА: {{ $error ?? 'undefined' }}
                                </p>
                                <p>
                                    ФАЙЛ: {{ $file ?? 'undefined' }}
                                </p>
                                <p>
                                    СТАКТРЕЙС:
                                    {{ $trace ?? 'undefined' }}
                                </p>
                                <p>
                                    {{ $info ?? 'error'}}
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <hr>
    Это автоматическое сообщение. Пожалуйста, не отвечайте на него.
    </body>
@endsection
