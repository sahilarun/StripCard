import 'dart:convert';

ProfileModel profileModelFromJson(String str) =>
    ProfileModel.fromJson(json.decode(str));

String profileModelToJson(ProfileModel data) => json.encode(data.toJson());

class ProfileModel {
  ProfileModel({
    required this.message,
    required this.data,
  });

  Message message;
  Data data;

  factory ProfileModel.fromJson(Map<String, dynamic> json) => ProfileModel(
        message: Message.fromJson(json["message"]),
        data: Data.fromJson(json["data"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message.toJson(),
        "data": data.toJson(),
      };
}

class Data {
  Data({
    required this.defaultImage,
    required this.imagePath,
    required this.user,
    required this.countries,
  });

  String defaultImage;
  String imagePath;
  User user;
  List<Country> countries;

  factory Data.fromJson(Map<String, dynamic> json) => Data(
        defaultImage: json["default_image"],
        imagePath: json["image_path"],
        user: User.fromJson(json["user"]),
        countries: List<Country>.from(
            json["countries"].map((x) => Country.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "default_image": defaultImage,
        "image_path": imagePath,
        "user": user.toJson(),
        "countries": List<dynamic>.from(countries.map((x) => x.toJson())),
      };
}

class Country {
  Country({
    required this.id,
    this.name,
    this.mobileCode,
    this.currencyName,
    this.currencyCode,
    this.currencySymbol,
  });

  int id;
  dynamic name;
  dynamic mobileCode;
  dynamic currencyName;
  dynamic currencyCode;
  dynamic currencySymbol;

  factory Country.fromJson(Map<String, dynamic> json) => Country(
        id: json["id"],
        name: json["name"] ?? '',
        mobileCode: json["mobile_code"] ?? '',
        currencyName: json["currency_name"] ?? '',
        currencyCode: json["currency_code"] ?? '',
        currencySymbol: json["currency_symbol"] ?? '',
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "name": name,
        "mobile_code": mobileCode,
        "currency_name": currencyName,
        "currency_code": currencyCode,
        "currency_symbol": currencySymbol,
      };
}

class User {
  User({
    required this.id,
    this.firstname,
    this.lastname,
    this.username,
    this.email,
    this.mobileCode,
    this.mobile,
    this.fullMobile,
    this.refferalUserId,
    this.image,
    required this.status,
    required this.address,
    required this.emailVerified,
    required this.smsVerified,
    required this.kycVerified,
    this.verCode,
    this.verCodeSendAt,
    required this.twoFactorVerified,
    this.deviceId,
    this.socialType,
    this.emailVerifiedAt,
    this.deletedAt,
    required this.createdAt,
    required this.updatedAt,
    this.fullname,
    this.userImage,
    required this.stringStatus,
    required this.emailStatus,
    this.lastLogin,
    required this.kycStringStatus,
  });

  int id;
  dynamic firstname;
  dynamic lastname;
  dynamic username;
  dynamic email;
  dynamic mobileCode;
  dynamic mobile;
  dynamic fullMobile;
  dynamic refferalUserId;
  dynamic image;
  int status;
  Address address;
  int emailVerified;
  int smsVerified;
  int kycVerified;
  dynamic verCode;
  dynamic verCodeSendAt;
  int twoFactorVerified;
  dynamic deviceId;
  dynamic socialType;
  dynamic emailVerifiedAt;
  dynamic deletedAt;
  DateTime createdAt;
  DateTime updatedAt;
  dynamic fullname;
  dynamic userImage;
  Status stringStatus;
  Status emailStatus;
  dynamic lastLogin;
  Status kycStringStatus;

  factory User.fromJson(Map<String, dynamic> json) => User(
        id: json["id"],
        firstname: json["firstname"] ?? '',
        lastname: json["lastname"] ?? '',
        username: json["username"] ?? '',
        email: json["email"] ?? '',
        mobileCode: json["mobile_code"] ?? '',
        mobile: json["mobile"] ?? '',
        fullMobile: json["full_mobile"] ?? '',
        refferalUserId: json["refferal_user_id"],
        image: json["image"],
        status: json["status"],
        address: Address.fromJson(json["address"]),
        emailVerified: json["email_verified"],
        smsVerified: json["sms_verified"],
        kycVerified: json["kyc_verified"],
        verCode: json["ver_code"],
        verCodeSendAt: json["ver_code_send_at"],
        twoFactorVerified: json["two_factor_verified"],
        deviceId: json["device_id"],
        socialType: json["social_type"],
        emailVerifiedAt: json["email_verified_at"],
        deletedAt: json["deleted_at"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
        fullname: json["fullname"] ?? '',
        userImage: json["userImage"] ?? '',
        stringStatus: Status.fromJson(json["stringStatus"]),
        emailStatus: Status.fromJson(json["emailStatus"]),
        lastLogin: json["lastLogin"] ?? '',
        kycStringStatus: Status.fromJson(json["kycStringStatus"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "firstname": firstname,
        "lastname": lastname,
        "username": username,
        "email": email,
        "mobile_code": mobileCode,
        "mobile": mobile,
        "full_mobile": fullMobile,
        "refferal_user_id": refferalUserId,
        "image": image,
        "status": status,
        "address": address.toJson(),
        "email_verified": emailVerified,
        "sms_verified": smsVerified,
        "kyc_verified": kycVerified,
        "ver_code": verCode,
        "ver_code_send_at": verCodeSendAt,
        "two_factor_verified": twoFactorVerified,
        "device_id": deviceId,
        "social_type": socialType,
        "email_verified_at": emailVerifiedAt,
        "deleted_at": deletedAt,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
        "fullname": fullname,
        "userImage": userImage,
        "stringStatus": stringStatus.toJson(),
        "emailStatus": emailStatus.toJson(),
        "lastLogin": lastLogin,
        "kycStringStatus": kycStringStatus.toJson(),
      };
}

class Address {
  Address({
    this.country,
    this.state,
    this.city,
    this.zip,
    this.address,
  });

  dynamic country;
  dynamic state;
  dynamic city;
  dynamic zip;
  dynamic address;

  factory Address.fromJson(Map<String, dynamic> json) => Address(
        country: json["country"] ?? '',
        state: json["state"] ?? '',
        city: json["city"] ?? '',
        zip: json["zip"] ?? '',
        address: json["address"] ?? '',
      );

  Map<String, dynamic> toJson() => {
        "country": country,
        "state": state,
        "city": city,
        "zip": zip,
        "address": address,
      };
}

class Status {
  Status({
    required this.statusClass,
    required this.value,
  });

  String statusClass;
  String value;

  factory Status.fromJson(Map<String, dynamic> json) => Status(
        statusClass: json["class"],
        value: json["value"],
      );

  Map<String, dynamic> toJson() => {
        "class": statusClass,
        "value": value,
      };
}

class Message {
  Message({
    required this.success,
  });

  List<String> success;

  factory Message.fromJson(Map<String, dynamic> json) => Message(
        success: List<String>.from(json["success"].map((x) => x)),
      );

  Map<String, dynamic> toJson() => {
        "success": List<dynamic>.from(success.map((x) => x)),
      };
}
