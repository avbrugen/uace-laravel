<h2>����� ������ �� ��������!</h2>
<p>� ���� <a href="{{ action('AuctionsController@getAuctionPage', ['id' => $lot_id]) }}">�{{ $lot_id }}</a> ��������� <a href="{{ action('DashboardController@getAuctionBidders', ['id' => $lot_id]) }}">����� ������</a> �� �������. ����������, ��������� �.</p>
<p><b>���������� � ���������</b></p>
<p>
    ID: {{ $lot_id }}<br/>
    �����: {{ $lot_title }}<br/>
    ��������: {{ $lot_category }}<br/>
    ̳�������������� �����: {{ trans('theme.regions.'. $lot_region) }}, �. {{ $lot_city }}<br/>
    �������� ���� �������: {{ $starting_price }}</p>
<p><b>���������� ��� �����������</b></p>
<p>��'� �� �������: {{ $first_name }} {{ $last_name }}<br/>
    E-mail: {{ $email }}<br/>
    @if($phone)
        ����� ��������: {{ $phone }}
    @endif
</p>