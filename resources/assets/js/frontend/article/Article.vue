<template>
  <div class="container-fulid">
    <div class="bg-image">
      <img class="image" src="https://images.unsplash.com/photo-1449023859676-22e61b0c0695?dpr=2&auto=format&fit=crop&w=1500&h=844&q=80&cs=tinysrgb&crop=">
    </div>
    <div class="container">
      <div class="row">
        <div class="title col-md-10 offset-md-3">
          <h3>字符串和字符（Strings and Characters）</h3>
        </div>
        <div class="content col-md-10 offset-md-3">
          pString是例如"hello, world"，"海贼王"这样的有序的Character（字符）类型的值的集合，通过String类型来表示。

          Swift 的String和Character类型提供了一个快速的，兼容 Unicode 的方式来处理代码中的文本信息。 创建和操作字符串的语法与 C 语言中字符串操作相似，轻量并且易读。 字符串连接操作只需要简单地通过+号将两个字符串相连即可。 与 Swift 中其他值一样，能否更改字符串的值，取决于其被定义为常量还是变量。

          尽管语法简易，但String类型是一种快速、现代化的字符串实现。 每一个字符串都是由独立编码的 Unicode 字符组成，并提供了以不同 Unicode 表示（representations）来访问这些字符的支持。

          Swift 可以在常量、变量、字面量和表达式中进行字符串插值操作，可以轻松创建用于展示、存储和打印的自定义字符串。

          注意：
          Swift 的String类型与 Foundation NSString类进行了无缝桥接。如果您利用 Cocoa 或 Cocoa Touch 中的 Foundation 框架进行工作。所有NSString API 都可以调用您创建的任意String类型的值。除此之外，还可以使用本章介绍的String特性。您也可以在任意要求传入NSString实例作为参数的 API 中使用String类型的值作为替代。 更多关于在 Foundation 和 Cocoa 中使用String的信息请查看 Using Swift with Cocoa and Objective-C。

          字符串字面量（String Literals）

          您可以在您的代码中包含一段预定义的字符串值作为字符串字面量。 字符串字面量是由双引号 ("") 包裹着的具有固定顺序的文本字符集。

          字符串字面量可以用于为常量和变量提供初始值。

          let someString = "Some string literal value"
          注意：
          someString常量通过字符串字面量进行初始化，Swift 因此推断该常量为String类型。
          字符串字面量可以包含以下特殊字符：

          转义字符\0(空字符)、\\(反斜线)、\t(水平制表符)、\n(换行符)、\r(回车符)、\"(双引号)、\'(单引号)。
          Unicode 标量，写成\u{n}(u为小写)，其中n为任意的一到八位十六进制数。
          下面的代码为各种特殊字符的使用示例。 wiseWords常量包含了两个转移特殊字符 (双括号)； dollarSign、blackHeart和sparklingHeart常量演示了三种不同格式的 Unicode 标量：

          let wiseWords = "\"我是要成为海贼王的男人\" - 路飞"
          // "我是要成为海贼王的男人" - 路飞
          let dollarSign = "\u{24}"             // $,  Unicode 标量 U+0024
          let blackHeart = "\u{2665}"           // ♥,  Unicode 标量 U+2665
          let sparklingHeart = "\u{1F496}"  // 💖, Unicode 标量 U+1F496

          初始化空字符串 (Initializing an Empty String)

          为了构造一个很长的字符串，可以创建一个空字符串作为初始值。 可以将空的字符串字面量赋值给变量，也可以初始化一个新的String实例：

          var emptyString = ""               // 空字符串字面量
          var anotherEmptyString = String()  // 初始化 String 实例
          // 两个字符串均为空并等价。
          您可以通过检查其Boolean类型的isEmpty属性来判断该字符串是否为空：

          if emptyString.isEmpty {
              println("什么都没有")
          }
          // 打印输出："什么都没有"

          字符串可变性 (String Mutability)

          您可以通过将一个特定字符串分配给一个变量来对其进行修改，或者分配给一个常量来保证其不会被修改：

          var variableString = "Horse"
          variableString += " and carriage"
          // variableString 现在为 "Horse and carriage"
          let constantString = "Highlander"
          constantString += " and another Highlander"
          // 这会报告一个编译错误 (compile-time error) - 常量不可以被修改。
          注意：
          在 Objective-C 和 Cocoa 中，您通过选择两个不同的类(NSString和NSMutableString)来指定该字符串是否可以被修改，Swift 中的字符串是否可以修改仅通过定义的是变量还是常量来决定，实现了多种类型可变性操作的统一。

          字符串是值类型（Strings Are Value Types）

          Swift 的String类型是值类型。 如果您创建了一个新的字符串，那么当其进行常量、变量赋值操作或在函数/方法中传递时，会进行值拷贝。 任何情况下，都会对已有字符串值创建新副本，并对该新副本进行传递或赋值操作。 值类型在 结构体和枚举是值类型 中进行了说明。

          注意：
          与 Cocoa 中的NSString不同，当您在 Cocoa 中创建了一个NSString实例，并将其传递给一个函数/方法，或者赋值给一个变量，您传递或赋值的是该NSString实例的一个引用，除非您特别要求进行值拷贝，否则字符串不会生成新的副本来进行赋值操作。
          Swift 默认字符串拷贝的方式保证了在函数/方法中传递的是字符串的值。 很明显无论该值来自于哪里，都是您独自拥有的。 您可以放心您传递的字符串本身不会被更改。

          在实际编译时，Swift 编译器会优化字符串的使用，使实际的复制只发生在绝对必要的情况下，这意味着您将字符串作为值类型的同时可以获得极高的性能。


          使用字符（Working with Characters）

          Swift 的String类型表示特定序列的Character（字符） 类型值的集合。 每一个字符值代表一个 Unicode 字符。 您可利用for-in循环来遍历字符串中的每一个字符：

          for character in "Dog!🐶" {
              println(character)
          }
          // D
          // o
          // g
          // !
          // 🐶
        </div>
        <div class="footer col-md-10 offset-md-3">
          <div class="user">
            <div class="info-left">
              <img class="avatar img-circle" width="60" src="https://pigjian.com/uploads/default_avatar.png">
            </div>
            <div class="info">
              <p class="username">小小程序员</p>
              <p class="description">一只走在编程这条不归路上的小北漂南方小伙，单身一枚！</p>
            </div>
            <button class="follow btn btn-outline-secondary btn-sm">关注</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {

  }
</script>

<style lang="scss" scoped>
  .row > div {
    display: block;
  }
  .title {
    margin-top: 30px;
    margin-bottom: 30px;

    h3 {
      font-weight: 300;
    }
  }
  .content {
    font-weight: 200;
    margin-bottom: 60px;
  }
  .footer {
    height: 80px;
    margin-bottom: 50px;
    border-top: 1px solid rgba(0, 0, 0, 0.04);
  }
  .user {
    position: relative;

    .info-left, .info {
      display: inline-block;
    }
    .info-left {
      position: absolute;
      left: 0;
      display: inline-block;
      margin: 10px 11px;
      line-height: 20px;
    }
    .info {
      position: absolute;
      left: 80px;
      display: inline-block;
      margin: 10px;
      height: 60px;
      line-height: 20px;

      p {
        margin: 9px 0;
      }
      .username {
        font-weight: 200;
      }
      .description {
        font-size: 12px;
        font-weight: 200;
      }
    }
    .follow {
      position: absolute;
      right: 0;
      top: 26.6667px;
    }
  }
  .image {
    width: 100%;
  }
  .bg-image {
    height: 500px;
    overflow: hidden;
  }
</style>
