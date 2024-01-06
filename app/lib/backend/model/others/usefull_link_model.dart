import 'dart:convert';

UseFullLinkModel useFullLinkModelFromJson(String str) =>
    UseFullLinkModel.fromJson(json.decode(str));

String useFullLinkModelToJson(UseFullLinkModel data) =>
    json.encode(data.toJson());

class UseFullLinkModel {
  UseFullLinkModel({
    required this.message,
    required this.data,
  });

  Message message;
  Data data;

  factory UseFullLinkModel.fromJson(Map<String, dynamic> json) =>
      UseFullLinkModel(
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
    this.about,
    this.contact,
    required this.policyPages,
  });

  dynamic about;
  dynamic contact;
  List<PolicyPage> policyPages;

  factory Data.fromJson(Map<String, dynamic> json) => Data(
        about: json["about"] ?? "",
        contact: json["contact"] ?? "",
        policyPages: List<PolicyPage>.from(
            json["policy_pages"].map((x) => PolicyPage.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "about": about,
        "contact": contact,
        "policy_pages": List<dynamic>.from(policyPages.map((x) => x.toJson())),
      };
}

class PolicyPage {
  PolicyPage({
    required this.id,
    this.slug,
    this.link,
  });

  int id;
  dynamic slug;
  dynamic link;

  factory PolicyPage.fromJson(Map<String, dynamic> json) => PolicyPage(
        id: json["id"],
        slug: json["slug"] ?? '',
        link: json["link"] ?? '',
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "slug": slug,
        "link": link,
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
