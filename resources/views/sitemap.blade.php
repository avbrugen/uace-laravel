<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<?php echo '<?xml-stylesheet type="text/xsl" href="http://uace.com.ua/static/sitemap.xsl"?>' ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
                <url>
					<loc>http://uace.com.ua/</loc>					<priority>1</priority>
					<changefreq>Weekly</changefreq>
				</url>
				<url>
					<loc>http://uace.com.ua/auctions</loc>					<priority>1</priority>
					<changefreq>Daily</changefreq>
				</url>
				
				@foreach($pages as $page)
				
				<url>
					<loc>{{action('PageController@getPage', ['slug' => $page->slug])}}</loc>
					<priority>0.6</priority>
					<changefreq>Weekly</changefreq>
				</url>
				
				@endforeach
					
				@foreach($news as $post)
				<url>
					<loc>{{action('NewsController@getArticle', ['slug' => $post->slug])}}</loc>
					<priority>0.6</priority>
					<changefreq>Weekly</changefreq>
				</url>
				@endforeach
				
				@foreach($auctions as $auction)
				<url>
					<loc>{{action('AuctionsController@getAuctionPageBySlug', ['id' => $auction->id, 'slug' => $auction->slug])}}</loc>
					<priority>0.6</priority>
					<changefreq>Weekly</changefreq>
				</url>
				@endforeach

</urlset>