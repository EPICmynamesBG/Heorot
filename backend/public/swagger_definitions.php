<?php

/**
 * @SWG\Definition(
 * 	    definition="ArrayBeerSuccess",
 * 		required={"status", "data"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Beer"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleBeerSuccess",
 * 		required={"status", "data"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Beer")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayBrewerySuccess",
 * 		required={"status", "data"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Brewery"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleBrewerySuccess",
 * 		required={"status", "data"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Brewery")
 * 	 )
 *
 *
 * @SWG\Definition(
 * 	    definition="ArrayStyleSuccess",
 * 		required={"status", "data"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Style"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleStyleSuccess",
 * 		required={"status", "data"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Style")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SearchSuccess",
 * 		required={"status", "data"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *      @SWG\Property(property="data", type="object", required=true, ref="#/definitions/SearchData")
 * 	 )
 *
 * @SWG\Definition(
 *   definition="SearchData",
 *   required={"beers", "breweries", "styles"},
 *   @SWG\Property(property="beers", type="array",
 *    @SWG\Items(
 *      ref="#/definitions/SearchBeerItem"
 *    )
 *   ),
 *   @SWG\Property(property="breweries", type="array",
 *     @SWG\Items(
 *       ref="#/definitions/SearchBreweryItem"
 *     )
 *   ),
 *   @SWG\Property(property="styles", type="array",
 *     @SWG\Items(
 *       ref="#/definitions/SearchStyleItem"
 *     )
 *   )
 * )
 *
 *
 * @SWG\Definition(
 *    definition="SearchBeerItem",
 *    type="object",
 *    required={"type", "beer", "style"},
 *    @SWG\Property(property="type", type="string", enum="['beer', 'brewery','style']", default="beer"),
 *    @SWG\Property(property="beer", type="object", ref="#/definitions/Beer"),
 * )
 *
 * @SWG\Definition(
 *    definition="SearchBreweryItem",
 *    type="object",
 *    required={"type", "beer", "style"},
 *    @SWG\Property(property="type", type="string", enum="['beer', 'brewery','style']", default="brewery"),
 *    @SWG\Property(property="beer", type="object", ref="#/definitions/Brewery")
 * )
 *
 * @SWG\Definition(
 *    definition="SearchStyleItem",
 *    type="object",
 *    required={"type", "beer", "style"},
 *    @SWG\Property(property="type", type="string", enum="['beer', 'brewery','style']", default="style"),
 *    @SWG\Property(property="style", type="object", ref="#/definitions/Style")
 * )
 *
 * @SWG\Definition(
 * 	    definition="BeerPostBody",
 *      type="object",
 * 		required={"name", "brewery", "cost"},
 *		@SWG\Property(property="name",type="string", default="Budweiser"),
 *		@SWG\Property(property="size",type="string", default="draught pint"),
 *		@SWG\Property(property="ibu",type="integer", default=60),
 *		@SWG\Property(property="brewery",type="object", ref="#/definitions/Brewery"),
 *		@SWG\Property(property="abv", type="double", default=6.7),
 *		@SWG\Property(property="description", type="string"),
 *		@SWG\Property(property="cost", type="double", default=2.50),
 *		@SWG\Property(property="style",type="object", ref="#/definitions/Style"),
 *      @SWG\Property(property="featured",type="boolean", default=false)
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="BreweryPostBody",
 *      type="object",
 * 		required={"name"},
 *		@SWG\Property(property="name",type="string", default="Anheuser-Busch"),
 *		@SWG\Property(property="location", type="string", default="Richmond, IN"),
 * 	 )
 */