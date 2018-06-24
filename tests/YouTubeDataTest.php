<?php

namespace BiteCodes\YouTubeData\Tests;

use BiteCodes\YouTubeData\Model\Channel;
use BiteCodes\YouTubeData\Model\ChannelBrandingSettings;
use BiteCodes\YouTubeData\Model\ChannelImage;
use BiteCodes\YouTubeData\Model\Thumbnail;
use BiteCodes\YouTubeData\Model\Video;
use BiteCodes\YouTubeData\Model\VideoContentDetails;
use BiteCodes\YouTubeData\Model\VideoStatistics;
use BiteCodes\YouTubeData\Response\ChannelListResponse;
use BiteCodes\YouTubeData\Response\SearchResponse;
use BiteCodes\YouTubeData\Response\VideoListResponse;
use BiteCodes\YouTubeData\YouTubeData;
use function GuzzleHttp\Psr7\parse_query;
use GuzzleHttp\Psr7\Response;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;

class YouTubeDataTest extends TestCase
{
    /** @test */
    public function it_returns_a_valid_video_search_response()
    {
        $response = new Response(200, [], file_get_contents(__DIR__ . '/Fixtures/search.json'));

        $client = new Client();
        $client->addResponse($response);

        $youtube = YouTubeData::create('some_key', $client);

        $result = $youtube->search('surfing', 5);

        ## Request
        $request = $client->getLastRequest();
        $query = parse_query($request->getUri()->getQuery());
        $this->assertEquals('some_key', $query['key']);
        $this->assertEquals('surfing', $query['q']);
        $this->assertEquals(5, $query['maxResults']);

        ## Response
        $this->assertInstanceOf(SearchResponse::class, $result);
        $this->assertEquals('ABCDEF', $result->getPrevPageToken());
        $this->assertEquals('CAUQAA', $result->getNextPageToken());
        $this->assertEquals(1000000, $result->getTotalResults());

        ## Video Mapping
        $this->assertCount(5, $result->getVideos());
        $video = $result->getVideos()[0];

        $this->assertEquals("fNr8kqSLpxQ", $video->getVideoId());
        $this->assertEquals("World's best surfing 2014/2015 (HD)", $video->getTitle());
        $this->assertEquals("Follow us on Twitter ...", $video->getDescription());
        $this->assertEquals("https://www.youtube.com/watch?v=fNr8kqSLpxQ", $video->getUrl());
        $this->assertEquals("UC3Yc0vyFkYXB1_njh3uj7yw", $video->getChannelId());
        $this->assertEquals("IcompilationTV", $video->getChannelTitle());
        $this->assertEquals("2014-11-12", $video->getPublishedAt()->format('Y-m-d'));
        $this->assertEquals("none", $video->getLiveBroadcastContent());

        ## Thumbnails
        $this->assertCount(3, $video->getThumbnails());
        $thumbnail = $video->getThumbnail(Thumbnail::TYPE_DEFAULT);

        $this->assertEquals('https://i.ytimg.com/vi/fNr8kqSLpxQ/default.jpg', $thumbnail->getUrl());
        $this->assertEquals(120, $thumbnail->getWidth());
        $this->assertEquals(90, $thumbnail->getHeight());
    }

    /** @test */
    public function it_returns_a_valid_video_list_response()
    {
        $response = new Response(200, [], file_get_contents(__DIR__ . '/Fixtures/video_list.json'));

        $client = new Client();
        $client->addResponse($response);

        $youtube = YouTubeData::create('some_key', $client);

        $result = $youtube->getVideoById('Ks-_Mh1QhMc');

        ## Request
        $request = $client->getLastRequest();
        $query = parse_query($request->getUri()->getQuery());
        $this->assertEquals('Ks-_Mh1QhMc', $query['id']);
        $this->assertEquals('snippet,contentDetails,statistics', $query['part']);
        $this->assertEquals('some_key', $query['key']);

        ## Response
        $this->assertInstanceOf(VideoListResponse::class, $result);

        ## Video Mapping
        $video = $result->getVideo();
        $this->assertInstanceOf(Video::class, $video);

        $this->assertEquals("Ks-_Mh1QhMc", $video->getVideoId());
        $this->assertEquals("Your body language may shape who you are | Amy Cuddy", $video->getTitle());
        $this->assertEquals("Body language affects how others see us...", $video->getDescription());
        $this->assertEquals("https://www.youtube.com/watch?v=Ks-_Mh1QhMc", $video->getUrl());
        $this->assertEquals("UCAuUUnT6oDeKwE6v1NGQxug", $video->getChannelId());
        $this->assertEquals("TED", $video->getChannelTitle());
        $this->assertEquals("2012-10-01", $video->getPublishedAt()->format('Y-m-d'));
        $this->assertEquals("none", $video->getLiveBroadcastContent());
        $this->assertEquals("22", $video->getCategoryId());
        $this->assertEquals(['Amy Cuddy', 'TED', 'psychology'], $video->getTags());
        $this->assertEquals('en', $video->getDefaultLanguage());
        $this->assertEquals('en', $video->getDefaultAudioLanguage());

        ## Thumbnails
        $this->assertCount(5, $video->getThumbnails());

        ## Statistics
        $stats = $video->getStatistics();
        $this->assertInstanceOf(VideoStatistics::class, $stats);
        $this->assertEquals(14411293, $stats->getViewCount());
        $this->assertEquals(188469, $stats->getLikeCount());
        $this->assertEquals(3658, $stats->getDislikeCount());
        $this->assertEquals(0, $stats->getFavoriteCount());
        $this->assertEquals(7045, $stats->getCommentCount());

        ## Content Details
        $details = $video->getDetails();
        $this->assertInstanceOf(VideoContentDetails::class, $details);
        $this->assertEquals('21', $details->getDuration()->format('%i'));
        $this->assertEquals('hd', $details->getDefinition());
        $this->assertEquals('2d', $details->getDimension());
        $this->assertEquals('rectangular', $details->getProjection());
        $this->assertEquals('true', $details->getCaption());
        $this->assertEquals(true, $details->isLicensedContent());
    }

    /** @test */
    public function it_returns_a_valid_channel_list_response()
    {
        $response = new Response(200, [], file_get_contents(__DIR__ . '/Fixtures/channel_list.json'));

        $client = new Client();
        $client->addResponse($response);

        $youtube = YouTubeData::create('some_key', $client);

        $result = $youtube->getChannelById('UC_x5XG1OV2P6uZZ5FSM9Ttw', ['snippet', 'contentDetails', 'statistics']);

        ## Request
        $request = $client->getLastRequest();
        $query = parse_query($request->getUri()->getQuery());
        $this->assertEquals('UC_x5XG1OV2P6uZZ5FSM9Ttw', $query['id']);
        $this->assertEquals('snippet,contentDetails,statistics', $query['part']);
        $this->assertEquals('some_key', $query['key']);

        ## Response
        $this->assertInstanceOf(ChannelListResponse::class, $result);

        ## Channel Mapping
        $channel = $result->getChannel();
        $this->assertInstanceOf(Channel::class, $channel);

        $this->assertEquals('UC_x5XG1OV2P6uZZ5FSM9Ttw', $channel->getId());
        $this->assertEquals('Google Developers', $channel->getTitle());
        $this->assertEquals('The Google Developers channel features talks...', $channel->getDescription());
        $this->assertEquals('https://www.youtube.com/channel/UC_x5XG1OV2P6uZZ5FSM9Ttw', $channel->getUrl());
        $this->assertEquals('GoogleDevelopers', $channel->getCustomUrl());
        $this->assertEquals('2007-08-23', $channel->getPublishedAt()->format('Y-m-d'));
        $this->assertCount(3, $channel->getThumbnails());
        $this->assertInstanceOf(Thumbnail::class, $channel->getThumbnail(Thumbnail::TYPE_DEFAULT));

        ## Brand Settings
        $brand = $channel->getBrandingSettings();

        $this->assertEquals('#000000', $brand->getProfileColor());
        $this->assertCount(14, $brand->getImages());
        $this->assertEquals(ChannelImage::BANNER_IMAGE_URL, $brand->getImageByType(ChannelImage::BANNER_IMAGE_URL)->getType());
    }
}
