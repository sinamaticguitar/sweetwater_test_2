{{-- Setting up high level variables --}}
@php($current_cat = '')

<html>
    <head>
        <style>
            #comments,
            #comments td {
                border-collapse: collapse;
            }

            .category {
                font-weight: bold;
                text-decoration: underline;
                font-size: 24px;
                padding-bottom: 10px;
                padding-top: 10px;
            }

            .order_id,
            .ship_date,
            .comment {
                padding: 5px;
            }

            .info_row {
                border: 1px solid #AAA;
            }

            .order_id {
            }

            .ship_date {
                text-align: right;
            }

            .comment {
                border: 1px solid #AAA;
            }

            .spacer {
                height: 10px;
            }
        </style>
    </head>
    <body>
        {{-- Begin the comments table --}}
        <table id="comments">
            @foreach($comments as $details)

            {{-- Category display logic --}}
            @if($current_cat != $details->category)
                @php($current_cat = $details->category)
                <tr><td colspan='2' class='category'>{{ $categories[$details->category ]}}</td></tr>
            @endif

                {{-- Comment display --}}
                <tr class='info_row'>
                    <td class='order_id'>Order ID: {{ $details->orderid }}</td>
                @if($details->shipdate_expected > 0)
                    <td class='ship_date'>Expected Ship Date: {{ date_format(date_create($details->shipdate_expected),"Y-m-d") }}</td>
                @endif
                </tr>
                <tr>
                    <td colspan='2' class='comment'>{!! nl2br($details->comments) !!}</td>
                </tr>
                <tr>
                    <td colspan='2' class='spacer'></td>
                </tr>

            @endforeach
        </table>
    </body>
</html>