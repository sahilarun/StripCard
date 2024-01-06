
class StripeCardDetailsModel {
  Message message;
  Data data;

  StripeCardDetailsModel({
    required this.message,
    required this.data,
  });

  factory StripeCardDetailsModel.fromJson(Map<String, dynamic> json) =>
      StripeCardDetailsModel(
        message: Message.fromJson(json["message"]),
        data: Data.fromJson(json["data"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message.toJson(),
        "data": data.toJson(),
      };
}

class Data {
  String baseCurr;
  CardDetails cardDetails;

  Data({
    required this.baseCurr,
    required this.cardDetails,
  });

  factory Data.fromJson(Map<String, dynamic> json) => Data(
        baseCurr: json["base_curr"],
        cardDetails: CardDetails.fromJson(json["card_details"]),
      );

  Map<String, dynamic> toJson() => {
        "base_curr": baseCurr,
        "card_details": cardDetails.toJson(),
      };
}

class CardDetails {
  int id;
  String cardId;
  String currency;
  String cardHolder;
  String brand;
  String type;
  String cardPan;
  String expiryMonth;
  String expiryYear;
  String cvv;
  String cardBackDetails;
  String siteTitle;
  String siteLogo;
  bool status;
  StatusInfo statusInfo;

  CardDetails({
    required this.id,
    required this.cardId,
    required this.currency,
    required this.cardHolder,
    required this.brand,
    required this.type,
    required this.cardPan,
    required this.expiryMonth,
    required this.expiryYear,
    required this.cvv,
    required this.cardBackDetails,
    required this.siteTitle,
    required this.siteLogo,
    required this.status,
    required this.statusInfo,
  });

  factory CardDetails.fromJson(Map<String, dynamic> json) => CardDetails(
        id: json["id"],
        cardId: json["card_id"],
        currency: json["currency"],
        cardHolder: json["card_holder"],
        brand: json["brand"],
        type: json["type"],
        cardPan: json["card_pan"],
        expiryMonth: json["expiry_month"],
        expiryYear: json["expiry_year"],
        cvv: json["cvv"],
        cardBackDetails: json["card_back_details"],
        siteTitle: json["site_title"],
        siteLogo: json["site_logo"],
        status: json["status"],
        statusInfo: StatusInfo.fromJson(json["status_info"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "card_id": cardId,
        "currency": currency,
        "card_holder": cardHolder,
        "brand": brand,
        "type": type,
        "card_pan": cardPan,
        "expiry_month": expiryMonth,
        "expiry_year": expiryYear,
        "cvv": cvv,
        "card_back_details": cardBackDetails,
        "site_title": siteTitle,
        "site_logo": siteLogo,
        "status": status,
        "status_info": statusInfo.toJson(),
      };
}

class StatusInfo {
  int active;
  int inactive;

  StatusInfo({
    required this.active,
    required this.inactive,
  });

  factory StatusInfo.fromJson(Map<String, dynamic> json) => StatusInfo(
        active: json["active"],
        inactive: json["inactive"],
      );

  Map<String, dynamic> toJson() => {
        "active": active,
        "inactive": inactive,
      };
}

class Message {
  List<String> success;

  Message({
    required this.success,
  });

  factory Message.fromJson(Map<String, dynamic> json) => Message(
        success: List<String>.from(json["success"].map((x) => x)),
      );

  Map<String, dynamic> toJson() => {
        "success": List<dynamic>.from(success.map((x) => x)),
      };
}
