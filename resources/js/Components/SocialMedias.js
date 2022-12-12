import Color from '../Utils/Colors/Color';

const ua = navigator.userAgent.toLowerCase();

export const socialLink = {
    buffer(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://bufferapp.com/add');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("text", title);
        return shareUrl.toString();
    },
    email(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('mailto:');
        let body = url;
        if (description) {
            body += "\n" + description;
        }
        shareUrl.searchParams.append("body", body);
        shareUrl.searchParams.append("subject", title);
        return shareUrl.toString();
    },
    evernote(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.evernote.com/clip.action');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    facebook(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL("https://www.facebook.com/sharer/sharer.php");
        shareUrl.searchParams.append("u", url);
        shareUrl.searchParams.append("title", title);
        if (description) {
            shareUrl.searchParams.append("description", description);
        }
        if (quote) {
            shareUrl.searchParams.append("quote", quote);
        }
        if (hashtags) {
            shareUrl.searchParams.append("hashtag", hashtags);
        }
        return shareUrl.toString();
    },
    flipboard(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://share.flipboard.com/bookmarklet/popout');
        shareUrl.searchParams.append("v", '2');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    hackernews(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://news.ycombinator.com/submitlink');
        shareUrl.searchParams.append("u", url);
        shareUrl.searchParams.append("t", title);
        return shareUrl.toString();
    },
    instapaper(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.instapaper.com/edit');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        if (description) {
            shareUrl.searchParams.append("description", description);
        }
        return shareUrl.toString();
    },
    line(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title + "\n" + url;
        if (description) {
            body += "\n" + description;
        }
        return 'http://line.me/R/msg/text/?' + encodeURIComponent(body);
    },
    linkedin(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.linkedin.com/sharing/share-offsite/?url=@u');
        shareUrl.searchParams.append("url", url);
        return shareUrl.toString();
    },
    messenger(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('fb-messenger://share/');
        shareUrl.searchParams.append("link", url);
        return shareUrl.toString();
    },
    pinterest(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://pinterest.com/pin/create/button/');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("media", media);
        shareUrl.searchParams.append("description", title);
        return shareUrl.toString();
    },
    pocket(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://getpocket.com/save');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    quora(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.quora.com/share');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    reddit(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.reddit.com/submit');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    skype(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title + "\n" + url;
        if (description) {
            body += "\n" + description;
        }
        return 'https://web.skype.com/share?url=' + encodeURIComponent(body);
    },
    sms(url = '', title = '', description = '', quote, hashtags, twitterUser, media) {
        let path = 'sms:?body=@t%0D%0A@u%0D%0A@d'
            .replace(/@u/g, encodeURIComponent(url))
            .replace(/@t/g, encodeURIComponent(title))
            .replace(/@d/g, encodeURIComponent(description))
        if ((ua.indexOf('iphone') > -1 || ua.indexOf('ipad') > -1)) {
            return path.replace(':?', ':&')
        }
        return path;
    },
    stumbleupon(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.stumbleupon.com/submit');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    telegram(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title;
        if (description) {
            body += "\n" + description;
        }
        let shareUrl = new URL('https://t.me/share/url');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("text", body);
        return shareUrl.toString();
    },
    tumblr(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.tumblr.com/share/link');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("name", title);
        if (description) {
            shareUrl.searchParams.append("description", description);
        }
        return shareUrl.toString();
    },
    twitter(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://twitter.com/intent/tweet');
        shareUrl.searchParams.append("text", title);
        shareUrl.searchParams.append("url", url);
        if (hashtags) {
            shareUrl.searchParams.append("hashtags", hashtags);
        }
        if (twitterUser) {
            shareUrl.searchParams.append("via", twitterUser);
        }
        return shareUrl.toString();
    },
    viber(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title + "\n" + url;
        if (description) {
            body += "\n" + description;
        }
        return 'viber://forward?text=' + encodeURIComponent(body);
    },
    vk(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://vk.com/share.php');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        shareUrl.searchParams.append("noparse", 'true');
        if (description) {
            shareUrl.searchParams.append("description", description);
        }
        if (media) {
            shareUrl.searchParams.append("image", media);
        }
        return shareUrl.toString();
    },
    weibo(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('http://service.weibo.com/share/share.php');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        if (media) {
            shareUrl.searchParams.append("pic", media);
        }
        return shareUrl.toString();
    },
    whatsapp(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title + "\n" + url;
        if (description) {
            body += "\n" + description;
        }
        let shareUrl = new URL('https://api.whatsapp.com/send?text=@t%0D%0A@u%0D%0A@d');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("text", body);
        return shareUrl.toString();
    },
    wordpress(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://wordpress.com/press-this.php');
        shareUrl.searchParams.append("u", url);
        shareUrl.searchParams.append("t", title);
        if (description) {
            shareUrl.searchParams.append("s", description);
        }
        if (media) {
            shareUrl.searchParams.append("i", media);
        }
        return shareUrl.toString();
    },
    xing(url, title, description, quote, hashtags, twitterUser, media) {
        let shareUrl = new URL('https://www.xing.com/social/share/spi');
        shareUrl.searchParams.append("op", 'share');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("title", title);
        return shareUrl.toString();
    },
    yammer(url, title, description, quote, hashtags, twitterUser, media) {
        let body = title;
        if (description) {
            body += "\n" + description;
        }
        let shareUrl = new URL('https://www.yammer.com/messages/new');
        shareUrl.searchParams.append("login", 'true');
        shareUrl.searchParams.append("url", url);
        shareUrl.searchParams.append("status", body);
        return shareUrl.toString();
    }
}

const buttonColors = function(baseColor, forceWhite = false) {
    baseColor = Color(baseColor);
    let white = Color('#ffffff');
    let black = Color('#000000');


    let color = baseColor.isDark() ? white : black;
    let hoverBackground = color === white ? baseColor.lighten(0.15) : baseColor.darken(0.15);
    let hoverColor = hoverBackground.isDark() ? white :black;
    let activeBackground = color === white ? baseColor.lighten(0.20) : baseColor.darken(0.20);
    let activeColor = activeBackground.isDark() ? white :black;
    let hoverBorder = color === white ? baseColor.lighten(0.20) : baseColor.darken(0.10);
    let activeBorder = color === white ? baseColor.lighten(0.10) : baseColor.darken(0.25);
    let borderShadowRgb = color.mix(baseColor, 0.15).rgb().array().join(',');
    return {
        color: color === black && forceWhite ? white.hex() : color.hex(),
        background: baseColor.hex(),
        border: baseColor.hex(),
        hoverColor: hoverColor === black && forceWhite ? white.hex() : hoverColor.hex(),
        hoverBackground: hoverBackground.hex(),
        hoverBorder: hoverBorder.hex(),
        activeColor: activeColor.hex(),
        activeBackground: activeBackground.hex(),
        activeBorder: activeBorder.hex(),
        disabledColor: color.hex(),
        disabledBackground: baseColor.hex(),
        disabledBorder: baseColor.hex(),
        borderShadowRgb: `rgb(${borderShadowRgb})`,
    };
}

export const socialInfo = {
    buffer: {
        name: 'Buffer',
        icon: 'buffer',
        iconType: 'brand',
        colors: buttonColors('#000000'),
    },
    email: {
        name: 'Email',
        icon: 'envelope',
        iconType: 'commom',
        colors: buttonColors('#909090', true),
    },
    evernote: {
        name: 'Evernote',
        icon: 'evernote',
        iconType: 'brand',
        colors: buttonColors('#00A82D'),
    },
    facebook: {
        name: 'Facebook',
        icon: 'facebook',
        iconType: 'brand',
        colors: buttonColors('#3b5998'),
    },
    flipboard: {
        name: 'Flipboard',
        icon: 'flipboard',
        iconType: 'brand',
        colors: buttonColors('#e12828'),
    },
    hackernews: {
        name: 'Hacker News',
        icon: 'hacker-news',
        iconType: 'brand',
        colors: buttonColors('#ff4000'),
    },
    instapaper: {
        name: 'Instapaper',
        icon: 'share',
        iconType: 'commom',
        colors: buttonColors('#1877F2'),
    },
    line: {
        name: 'Line',
        icon: 'line',
        iconType: 'brand',
        colors: buttonColors('#06C755'),
    },
    linkedin: {
        name: 'LinkedIn',
        icon: 'linkedin',
        iconType: 'brand',
        colors: buttonColors('#0a66c2'),
    },
    messenger: {
        name: 'Messenger',
        icon: 'facebook-messenger',
        iconType: 'brand',
        colors: buttonColors('#006AFF'),
    },
    pinterest: {
        name: 'Pinterest',
        icon: 'pinterest',
        iconType: 'brand',
        colors: buttonColors('#bd081c'),
    },
    pocket: {
        name: 'Pocket',
        icon: 'get-pocket',
        iconType: 'brand',
        colors: buttonColors('#ee4056'),
    },
    quora: {
        name: 'Quora',
        icon: 'quora',
        iconType: 'brand',
        colors: buttonColors('#aa2200'),
    },
    reddit: {
        name: 'Reddit',
        icon: 'reddit',
        iconType: 'brand',
        colors: buttonColors('#ff5700'),
    },
    skype: {
        name: 'Skype',
        icon: 'skype',
        iconType: 'brand',
        colors: buttonColors('#00aff0', true),
    },
    sms: {
        name: 'SMS',
        icon: 'comment',
        iconType: 'commom',
        colors: buttonColors('#9F2B68'),
    },
    stumbleupon: {
        name: 'StumbleUpon',
        icon: 'stumbleupon',
        iconType: 'brand',
        colors: buttonColors('#e94826'),
    },
    telegram: {
        name: 'Telegram',
        icon: 'telegram',
        iconType: 'brand',
        colors: buttonColors('#0088cc', true),
    },
    tumblr: {
        name: 'Tumblr',
        icon: 'tumblr',
        iconType: 'brand',
        colors: buttonColors('#35465d'),
    },
    twitter: {
        name: 'Twitter',
        icon: 'twitter',
        iconType: 'brand',
        colors: buttonColors('#1DA1F2', true),
    },
    viber: {
        name: 'Viber',
        icon: 'viber',
        iconType: 'brand',
        colors: buttonColors('#7360f2'),
    },
    vk: {
        name: 'VK',
        icon: 'vk',
        iconType: 'brand',
        colors: buttonColors('#4a76a8'),
    },
    weibo: {
        name: 'Weibo',
        icon: 'weibo',
        iconType: 'brand',
        colors: buttonColors('#DF2029'),
    },
    whatsapp: {
        name: 'WhatsApp',
        icon: 'whatsapp',
        iconType: 'brand',
        colors: buttonColors('#25D366', true),
    },
    wordpress: {
        name: 'WordPress',
        icon: 'wordpress',
        iconType: 'brand',
        colors: buttonColors('#21759b'),
    },
    xing: {
        name: 'Xing',
        icon: 'xing',
        iconType: 'brand',
        colors: buttonColors('#cfdc00'),
    },
    yammer: {
        name: 'Yammer',
        icon: 'yammer',
        iconType: 'brand',
        colors: buttonColors('#0358A7'),
    }
}
