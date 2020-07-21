# liloapp
URL : http://localhost/liloapp/api/

x-api-key `SyoGQGcPwaR4yxIUXwbo_THeKZkL#@$8X8&8z`

## Table of contents

1. **Visitors**
    + [Guest Login](#guest-login)


## Visitors

### Guest Login
POST `api/visitors/geust-login/`   

##### Payload

|      Name      | Required |   Type    |    Description        |    Sample Data 
|----------------|----------|-----------|-----------------------|-----------------------
| fullname        |  yes     |  varchar      |        -              |  Elline Ocampo
| agency        |       |  varchar      |        id of from tbl.agency              |  1
| attached_agency        |       |  varchar      |        -              |  
| email_address        |  yes     |  varchar      |        -              |  edocampo@myoptimind.com
| is_have_ecopy        |       |  varchar      |        0 = none, 1 = yes              |  1
| photo       |  yes     |  file |      |  testing.pmg
| division_to_visit        |  yes     |  varchar      |        id of from tbl.division              |  2
| purpose        |  yes     |  varchar      |        -              |  Meeting
| person_to_visit        |  yes     |  varchar      |        id of from tbl.staffs             |  1
| temperature        |  yes     |  varchar      |        -              |  37.3
| place_of_origin        |  yes     |  varchar      |        -              |  San Mateo, Rizal
| mobile_number       |  yes     |  varchar |      |  09497912581
| health_condition        |  yes     |  varchar      |                      |  Normal
| pin_code        |  yes     |  varchar      |        Random Character; unique             |  zXc12365gfd


##### Response
```javascript
201 OK
{
    "data": {
        "fullname": "Elline Ocampo",
        "agency": "2",
        "attached_agency": "1",
        "email_address": "edocampo@myoptimind.com",
        "is_have_ecopy": "1",
        "division_to_visit": "3",
        "purpose": "Meeting",
        "person_to_visit": "1",
        "temperature": "36.5",
        "place_of_origin": "San Mateo, Rizal",
        "mobile_number": "09497912581",
        "health_condition": "Normal",
        "pin_code": "zXc12365gfd"
    },
    "meta": {
        "message": "Visitor login successfully",
        "status": "200"
    }
}
```