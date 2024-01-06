import 'dart:convert';

AppSettingsModel appSettingsModelFromJson(String str) =>
    AppSettingsModel.fromJson(json.decode(str));

String appSettingsModelToJson(AppSettingsModel data) =>
    json.encode(data.toJson());

class AppSettingsModel {
  AppSettingsModel({
    required this.message,
    required this.data,
  });

  Message message;
  Data data;

  factory AppSettingsModel.fromJson(Map<String, dynamic> json) =>
      AppSettingsModel(
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
    required this.defaultLogo,
    required this.imagePath,
    required this.onboardScreen,
    required this.splashScreen,
    required this.appUrl,
    required this.allLogo,
    required this.logoImagePath,
  });

  String defaultLogo;
  String imagePath;
  List<OnboardScreen> onboardScreen;
  SplashScreen splashScreen;
  AppUrl appUrl;
  AllLogo allLogo;
  String logoImagePath;

  factory Data.fromJson(Map<String, dynamic> json) => Data(
        defaultLogo: json["default_logo"],
        imagePath: json["image_path"],
        onboardScreen: List<OnboardScreen>.from(
            json["onboard_screen"].map((x) => OnboardScreen.fromJson(x))),
        splashScreen: SplashScreen.fromJson(json["splash_screen"]),
        appUrl: AppUrl.fromJson(json["app_url"]),
        allLogo: AllLogo.fromJson(json["all_logo"]),
        logoImagePath: json["logo_image_path"],
      );

  Map<String, dynamic> toJson() => {
        "default_logo": defaultLogo,
        "image_path": imagePath,
        "onboard_screen":
            List<dynamic>.from(onboardScreen.map((x) => x.toJson())),
        "splash_screen": splashScreen.toJson(),
        "app_url": appUrl.toJson(),
        "all_logo": allLogo.toJson(),
        "logo_image_path": logoImagePath,
      };
}

class AllLogo {
  AllLogo({
    required this.siteLogoDark,
    required this.siteLogo,
    required this.siteFavDark,
    required this.siteFav,
  });

  String siteLogoDark;
  String siteLogo;
  String siteFavDark;
  String siteFav;

  factory AllLogo.fromJson(Map<String, dynamic> json) => AllLogo(
        siteLogoDark: json["site_logo_dark"],
        siteLogo: json["site_logo"],
        siteFavDark: json["site_fav_dark"],
        siteFav: json["site_fav"],
      );

  Map<String, dynamic> toJson() => {
        "site_logo_dark": siteLogoDark,
        "site_logo": siteLogo,
        "site_fav_dark": siteFavDark,
        "site_fav": siteFav,
      };
}

class AppUrl {
  AppUrl({
    required this.id,
    this.androidUrl,
    this.isoUrl,
    required this.createdAt,
    required this.updatedAt,
  });

  int id;
  dynamic androidUrl;
  dynamic isoUrl;
  DateTime createdAt;
  DateTime updatedAt;

  factory AppUrl.fromJson(Map<String, dynamic> json) => AppUrl(
        id: json["id"],
        androidUrl: json["android_url"],
        isoUrl: json["iso_url"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "android_url": androidUrl,
        "iso_url": isoUrl,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
      };
}

class OnboardScreen {
  OnboardScreen({
    required this.id,
    required this.title,
    required this.subTitle,
    required this.image,
    required this.status,
    required this.createdAt,
    required this.updatedAt,
  });

  int id;
  dynamic title;
  dynamic subTitle;
  dynamic image;
  int status;
  DateTime createdAt;
  DateTime updatedAt;

  factory OnboardScreen.fromJson(Map<String, dynamic> json) => OnboardScreen(
        id: json["id"],
        title: json["title"],
        subTitle: json["sub_title"],
        image: json["image"],
        status: json["status"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "title": title,
        "sub_title": subTitle,
        "image": image,
        "status": status,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
      };
}

class SplashScreen {
  SplashScreen({
    required this.id,
    required this.splashScreenImage,
    required this.version,
    required this.createdAt,
    required this.updatedAt,
  });

  int id;
  String splashScreenImage;
  String version;
  DateTime createdAt;
  DateTime updatedAt;

  factory SplashScreen.fromJson(Map<String, dynamic> json) => SplashScreen(
        id: json["id"],
        splashScreenImage: json["splash_screen_image"],
        version: json["version"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "splash_screen_image": splashScreenImage,
        "version": version,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
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
