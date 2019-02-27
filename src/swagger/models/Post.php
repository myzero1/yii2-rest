<?php

/**
    @SWG\Tag(
        name="posts",
        description="posts",
        @SWG\ExternalDocumentation(
            description="Find out more about our store",
            url="http://swagger.io"
        )
    )
 */

/**
    @SWG\Definition(
        definition="Post",
        required={"userId"},

        @SWG\Property(
            property="userId",
            type="string",
            description="userId",
            example="userId"
        ),
        @SWG\Property(
            property="title",
            type="string",
            description="title",
            example="title"
        ),
        @SWG\Property(
            property="body",
            type="string",
            description="body",
            example="body"
        ),
        @SWG\Property(
            property="created_at",
            type="string",
            description="created_at",
            example="created_at"
        ),
        @SWG\Property(
            property="updated_at",
            type="string",
            description="updated_at",
            example="updated_at"
        ),
    
    )
 */