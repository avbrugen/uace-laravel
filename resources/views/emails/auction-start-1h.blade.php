<h2>������� ���������� ������� �{{ $auction_id }}</h2>
<p><b>����������</b></p>
<p>
    ��������: {{ $auction_title }}<br/>
    ������: {{ action('AuctionsController@getAuctionPage', ['id' => $auction_id]) }}</p>