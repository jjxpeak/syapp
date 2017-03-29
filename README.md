#syapp
>###介绍：
    该项目为学习目的，如有错误欢迎指正
## [git](#git)

>### git

- 笔记

    1. 版本库
        - 创建版本库 git init
        - 添加文件到仓库 
            1. git add \<name>
            2. git commit -m '版本说明'
        - 查看log日志 git log
        - 版本回退 git reset --hard \<commit id>
        - 查看历史命令 git reflog
        - 查看工作区改动文件 git status
        - 查看工作区与版本库文件内容差异 git diff HEAD -- \<name>
        - 撤销工作区的修改 git checkout -- \<name>
        - 撤销暂存区的修改 git reset HEAD \<name>
        - 删除版本中文件
            1. git rm
            2. git commit
    1. 远程仓库
        - 关联远程仓库
            1. 生成公钥 ssh-keygen -t rsa -C "email"
            1. 将生成的公钥配置到远程仓库中
            1. 用 git remote add origin git@servername:仓库用户名/rep-name.git
            1. 推送本地仓库 git push -u origin master 推送master所有内容
            1. git push origin master 推送最新改动
        - 克隆远程仓库 git clone \<url>
    1. 分支
        - 查看分支 git branch
        - 创建分支 git branch \<name>
        - 切换分支 git checkout \<name>
        - 创建+切换分支 git checkout -b \<name>
        - 合并某一分支到当前分支 git merge <name>
        - 删除分支 git branch -d \<name> 
            
  
        
