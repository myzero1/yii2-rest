<?php
/**
     @SWG\Get(path="/posts",
         tags={"posts"},
         summary="record list",
         description="Record list: actionIndex GET_LIST GET /posts?sort=[""id"",""ASC""]&range=[0, 2]&filter={""status"":""10"",""ids"":[1,3,5]}",
         produces={"application/json"},
     
         @SWG\Parameter(
            in = "query",
            name = "sort",
            description = "sort",
            required = false,
            type = "string",
            default = "[""id"",""ASC""]",
         ),
         @SWG\Parameter(
            in = "query",
            name = "range",
            description = "range",
            required = false,
            type = "string",
            default = "[0, 10]",
         ),
         @SWG\Parameter(
            in = "query",
            name = "filter",
            description = "filter",
            required = false,
            type = "string",
            default = "{""id"":""1"",""ids"":[1,3,5]}",
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
     
     
     
     @SWG\Get(path="/posts/{id}",
         tags={"posts"},
         summary="record view",
         description="Record list: actionView GET_ONE GET /posts/1",
         produces={"application/json"},
     
         @SWG\Parameter(
            in = "path",
            name = "id",
            description = "record id",
            required = true,
            type = "integer",
            default = 1,
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
     
     
     
     @SWG\Post(path="/posts",
         tags={"posts"},
         summary="record create",
         description="Record create: actionCreate CREATE Post /posts",
         produces={"application/json"},
     
         @SWG\Parameter(
            in = "body",
            name = "body",
            description = "record content",
            required = true,
            type = "string",
            @SWG\Schema(ref = "#/definitions/User")
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
     
     
     
     @SWG\Put(path="/posts/{id}",
         tags={"posts"},
         summary="record update",
         description="Record update: actionUpdate UPDATE PUT /posts/1",
         produces={"application/json"},
     
         @SWG\Parameter(
            in = "path",
            name = "id",
            description = "record id",
            required = true,
            type = "integer",
            default = 1,
         ),
         @SWG\Parameter(
            in = "body",
            name = "body",
            description = "update content",
            required = true,
                type = "string",
            @SWG\Schema(ref = "#/definitions/User")
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
     
     
     
     @SWG\Delete(path="/posts/{id}",
         tags={"posts"},
         summary="record delete",
         description="Record delete: actionDelete DELETE DELETE  /posts/1",
         produces={"application/json"},
     
         @SWG\Parameter(
            in = "path",
            name = "id",
            description = "record id",
            required = true,
            type = "integer",
            default = 1,
         ),
     
         @SWG\Response(
             response = 200,
             description = "success"
         )
     )
 */