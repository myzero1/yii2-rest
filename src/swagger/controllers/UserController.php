<?php
/**
     @SWG\Get(path="/users",
         tags={"users"},
         summary="record list",
         description="Record list: actionIndex GET_LIST GET /users?sort=[""id"",""ASC""]&range=[0, 2]&filter={""status"":""10"",""ids"":[1,3,5]}",
         produces={"application/json"},
    
         @SWG\Parameter(
            in = "header",
            name = "Authorization",
            description = "Authorization",
            required = true,
            type = "string",
            default = "Bearer MM029y0i0yTqJFuzBMZXMRGU2VBMK32a_1551337412",
         ),
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
     
     
     
     @SWG\Get(path="/users/{id}",
         tags={"users"},
         summary="record view",
         description="Record list: actionView GET_ONE GET /users/1",
         produces={"application/json"},

         @SWG\Parameter(
            in = "header",
            name = "Authorization",
            description = "Authorization",
            required = true,
            type = "string",
            default = "Bearer MM029y0i0yTqJFuzBMZXMRGU2VBMK32a_1551337412",
         ),
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
     
     
     
     @SWG\Post(path="/users",
         tags={"users"},
         summary="record create",
         description="Record create: actionCreate CREATE Post /users",
         produces={"application/json"},

         @SWG\Parameter(
            in = "header",
            name = "Authorization",
            description = "Authorization",
            required = true,
            type = "string",
            default = "Bearer MM029y0i0yTqJFuzBMZXMRGU2VBMK32a_1551337412",
         ),
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
     
     
     
     @SWG\Put(path="/users/{id}",
         tags={"users"},
         summary="record update",
         description="Record update: actionUpdate UPDATE PUT /users/1",
         produces={"application/json"},

         @SWG\Parameter(
            in = "header",
            name = "Authorization",
            description = "Authorization",
            required = true,
            type = "string",
            default = "Bearer MM029y0i0yTqJFuzBMZXMRGU2VBMK32a_1551337412",
         ),
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
     
     
     
     @SWG\Delete(path="/users/{id}",
         tags={"users"},
         summary="record delete",
         description="Record delete: actionDelete DELETE DELETE  /users/1",
         produces={"application/json"},

         @SWG\Parameter(
            in = "header",
            name = "Authorization",
            description = "Authorization",
            required = true,
            type = "string",
            default = "Bearer MM029y0i0yTqJFuzBMZXMRGU2VBMK32a_1551337412",
         ),
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