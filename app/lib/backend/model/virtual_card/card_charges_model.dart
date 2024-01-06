import 'dart:convert';

CardChargesModel cardChargesModelFromJson(String str) =>
    CardChargesModel.fromJson(json.decode(str));

String cardChargesModelToJson(CardChargesModel data) =>
    json.encode(data.toJson());

class CardChargesModel {
  CardChargesModel({
    required this.message,
    required this.data,
  });

  Message message;
  Data data;

  factory CardChargesModel.fromJson(Map<String, dynamic> json) =>
      CardChargesModel(
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
    required this.baseCurr,
    required this.cardCharge,
    required this.withdrawCharges,
  });

  String baseCurr;
  CardCharge cardCharge;
  CardCharge withdrawCharges;

  factory Data.fromJson(Map<String, dynamic> json) => Data(
        baseCurr: json["base_curr"],
        cardCharge: CardCharge.fromJson(json["cardCharge"]),
        withdrawCharges: CardCharge.fromJson(json["withdrawCharges"]),
      );

  Map<String, dynamic> toJson() => {
        "base_curr": baseCurr,
        "cardCharge": cardCharge.toJson(),
        "withdrawCharges": withdrawCharges.toJson(),
      };
}

class CardCharge {
  CardCharge({
    required this.id,
    required this.slug,
    required this.title,
    required this.fixedCharge,
    required this.percentCharge,
    required this.minLimit,
    required this.maxLimit,
  });

  int id;
  String slug;
  String title;
  int fixedCharge;
  int percentCharge;
  int minLimit;
  int maxLimit;

  factory CardCharge.fromJson(Map<String, dynamic> json) => CardCharge(
        id: json["id"],
        slug: json["slug"],
        title: json["title"],
        fixedCharge: json["fixed_charge"],
        percentCharge: json["percent_charge"],
        minLimit: json["min_limit"],
        maxLimit: json["max_limit"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "slug": slug,
        "title": title,
        "fixed_charge": fixedCharge,
        "percent_charge": percentCharge,
        "min_limit": minLimit,
        "max_limit": maxLimit,
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
