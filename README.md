template-generator
==================
framework template-generator / database scheme builder  
ご利用前に
```bash
$ composer update
```

実行方法は簡単です
```bash
$ php console generate:template
```


現在指定出来るoptionは、  
--path : 読み込むファイルを指定  
--output : 出力するディレクトリを指定  
--framework : フレームワークを指定出来ますが、お使いのフレームワークに合わせて実装が必要です  

指定が無い場合は、  
app/storage/template/template.xlsが読み込まれ、  
app/storage/output に出力され、  
frameworkはlaravelに合わせたものが出力されます。  

出力先のディレクトリ権限を777にするのを忘れずに。

他のフレームワークや自分好みのフォーマットを作成するのも簡単に出来ます。  
databaseの定義をxls以外にも、xmlやjsonなどどんなものでも独自に実装が可能です。(実装方法はソース参照)  
