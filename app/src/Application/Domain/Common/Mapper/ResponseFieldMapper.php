<?php


namespace App\Application\Domain\Common\Mapper;


abstract class ResponseFieldMapper
{
    const USER_PASSWORD = 'password';
    const USER_TOKEN = 'token';
    const USER_ID = 'userId';
    const USER_EMAIL = 'email';
    const USER_NICK = 'userNick';

    const UNLOCKED_BEERS = 'unlockedBeers';
    const ALL_BEERS = 'allBeers';
    const BEERS = 'beers';
    const BEER = 'beer';
    const BEER_ID = 'beerId';
    const BEER_NAME = 'beerName';
    const BEER_TITLE = 'beerTitle';
    const BEER_CODE = 'beerCode';
    const BEER_BACKGROUND_IMAGE = 'beerBackgroundImage';
    const BEER_CREATED_AT = 'beerCreatedAt';
    const BEER_DESCRIPTION = 'beerDescription';
    const BEER_HOPS = 'beerHops';
    const BEER_ICON = 'beerIcon';
    const BEER_MALTS = 'beerMalts';
    const BEER_TAGS = 'beerTags';
    const BEER_REVIEWS = 'beerReviews';
    const BEER_STATUS = 'beerStatus';
    const BEER_RATING = 'beerRating';

    const REVIEW_ID = 'reviewId';
    const REVIEW_TEXT = 'reviewText';
    const REVIEW_RATING = 'reviewRating';
    const REVIEW_CREATED_AT = 'reviewCreatedAt';
    const REVIEW_OWNER = 'reviewOwner';
}