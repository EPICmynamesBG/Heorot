<?php

/**
 * @SWG\Definition(
 * 	    definition="ArrayBeerSuccess",
 * 		required={"status", "message"},
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
 * 		required={"status", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Beer")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayBrewerySuccess",
 * 		required={"status", "message"},
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
 * 		required={"status", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Brewery")
 * 	 )
 *
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
 *		@SWG\Property(property="cost", type="double", default=2.50)
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
