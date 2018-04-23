<template>
  <div class="join">
    <Head></Head>
    <div class="joinH">
      <div class="banner"></div>
      <!--<img src="../assets/joinUs/banner.png" alt="" class="bannerH">-->
    </div>
    <h3>JOIN&nbsp;US</h3>
    <p class="subhead">我们需要以下职位</p>
    <ul class="list">
      <li v-for="(items, index) in job" :key="index" class="lis">
        <div class="con">
          <h1>{{items.name}}</h1>
          <p class="en">{{items.en}}</p>
          <div class="need">
            <p class="t">{{items.need}}</p>
            <ul class="purchase">
              <li v-for="(item, index) in items.intr" :key="index">{{item}}</li>
            </ul>
            <p class="re">任职要求:</p>
            <ol class="require">
              <li v-for="(item, index) in items.require" :key="index">{{item}}</li>
            </ol>
          </div>
          <img v-if="items.upshow === false" src="../assets/joinUs/up.png" alt="" class="upDown" @click="up($event, items)">
          <img v-else src="../assets/joinUs/down.png" alt="" class="upDown" @click="down($event, items)">
          <span class="online">网上招聘渠道</span>
          <span class="email">HR邮箱直投</span>
        </div>
      </li>
    </ul>
    <foot></foot>
  </div>
</template>
<script>
import Head from './head-nav.vue'
import foot from './footNav.vue'
import $ from 'jquery'
export default {
  name: 'join-us',
  metaInfo () {
    const title = '加入我们 - 道达智装'
    return {
      title: title,
      meta: [{vmid: 'keywords', name: 'keywords', content: title}]
    }
  },
  data () {
    return {
      job: [
        {
          upshow: true,
          name: '薪酬经理',
          en: 'Compensation manager',
          need: '岗位职责',
          intr: [
            '1、负责公司薪酬绩效体系的搭建和执行；',
            '2、负责薪酬制度、考核制度以及相关流程、表单的设计与完善；',
            '3、实施全国市场薪酬与社保政策调研；完善总部薪酬福利体系；',
            '4、负责子公司年度预算组织、审核；负责子公司月度人工成本和人员编制预算监控（通过EHR、人事台账、报表系统进行管理）；',
            '5、建立人力资源管理指标分析体系，提升公司整体人事运营效率；',
            '6、负责对绩效考核结果进行分析，为人才梯度、人员晋升、降职、调动提供绩效考核依据；',
            '7、负责人力资源成本分析，预算各基地、各部门当年工资总额，报人力资源部审核；',
            '8、负责员工福利体系的建设与执行，负责企业激励机制和企业文化的建设；',
            '9、负责审查各基地、部门的薪资情况，对每月工资进行统计分析，并且对薪资的变动情况及时反映，提出处理方案，方案确定后监督执行。'
          ],
          require: [
            '1、要求本科以上学历，建筑类行业5年以上薪酬福利或绩效经理岗位工作经验优先； ',
            '2、掌握先进的薪酬、绩效管理工具，具备独立设计薪酬福利或绩效管理体系的能力； ',
            '3、熟悉薪酬绩效管理的工作流程和设计工具，熟悉金融行业团队管理、业务团队激励与薪资奖金核算经验优先； ',
            '4、有较强的数据分析和统计能力，较强的公文写作能力; ',
            '5、 熟悉劳动、工资、保险、个人所得税及社会保险福利等政策法规； ',
            '6、 具有一定的财务知识，对数据敏感，有良好的数字分析能力； ',
            '7、 良好的职业道德素养,耐心细致、成熟稳重、诚信正直； ',
            '8、 较强的服务意识和沟通与协调能力。'
          ]
        },
        {
          upshow: true,
          name: '软装设计师 ',
          en: 'Interior decoration designer',
          need: '岗位职责',
          intr: [
            '1、负责店铺内商品的美观陈列、商品价格的标识与更换；',
            '2、引导客户挑选软装区域商品，包括：窗帘、灯具、家具、风水摆件、餐具等；',
            '3、维护好与客户之间的关系。'
          ],
          require: [
            '1、应届生优先考虑；',
            '2、良好的沟通技巧，及较强的团队意识和服务意识；',
            '3、责任心强，有较强的学习能力。 ',
            '4、有在大型著名装修企业工作资历者优先。'
          ]
        },
        {
          upshow: true,
          name: '室内设计师 ',
          en: 'Interior designer ',
          need: '岗位职责',
          intr: [
            '1、负责向客户提供完整的设计方案、设计流行元素及设计风格，并协助方案的实施；',
            '2、 负责客户洽谈，量房，设计方案的拟定，图纸绘制，合同签订等工作；',
            '3、 做好图纸交底、会审工作，向工程部施工人员做好图纸解释说明工作；',
            '4、 协调客户、施工、材料各方面的关系，保证设计方案能顺利执行；',
            '5、 提供给客户各种专业的咨询服务，并提供合理的协助。'
          ],
          require: [
            '1、本科及以上学历，5年以上工作经验，室内设计或建筑装潢设计专业优先。',
            '2、能熟练使用（AUTO CAD、PHOTOSHOP、Sketchup等设计软件和办公室软件）；',
            '3、有责任心，善于沟通，团队协作意识强，有较强的专研和自学能力，吃苦耐劳有敬业精神。',
            '4、有在大型著名装修企业工作资历者优先。'
          ]
        },
        {
          upshow: true,
          name: '预算专员 ',
          en: 'Budget Commissioner',
          need: '岗位职责',
          intr: [
            '1、从事室内家装与工装预算或相关行业3年以上经验。',
            '2、负责施工项目的工程预（结）算工作，及时办理和完成预（结）算工作。',
            '3、参加图纸会审、设计预算审查，根据有关文件规定配合解决预（结）算中的问题。',
            '4、参加领导安排的招投标会议。认真做好预（结）算会审纪要，对预（结）算中的定额换算、取费标准、材料价差进行复核，发现问题及时反映，做到预（结）算工作的及时性和准确性，对自己所做的工作负责。',
            '5、对在预（结）算工作中，发现的有关施工图纸的问题，应及时与设计师及设计总监负责人反映。',
            '6、加强专业知识的学习，不断提高预算技能，提高实际的工作效率。'
          ],
          require: [
            '1、大专及以上学历，3年以上预算相关工作经验；',
            '2、熟悉装饰施工一般工艺标准，了解施工现场工作流程和环节；',
            '3、熟悉上海装饰材料市场的价格动向，了解相关造价信息和材料信息；',
            '4、工作严谨，善于沟通，具备良好的团队合作精神和职业操守；',
            '5、预算，具有造价员资格证书者优先。'
          ]
        },
        {
          upshow: true,
          name: '营销经理 ',
          en: 'Marketing manager',
          need: '岗位职责',
          intr: [
            '1.参与制定公司的营销战略，根据营销战略制定公司营销组合策略，经批准后组织实施。',
            '2.对公司所进行的各项活动、广告、公关活动、营销等进行整合策划；',
            '3.参与公司市场的建立和推广；',
            '4.指导营销工作的进行，监督部门员工工作的质量，以及客户关系的维护和开发；',
            '5. 领导安排的其他工作。'
          ],
          require: [
            '1.大学专科以上学历，从事营销总监或营销经理5-8年以上工作经验；',
            '2.善于和客户交流沟通，有一定的客户资源和大型装企经验者优先。',
            '3.具有操作中高端客户的思维方式；',
            '4.小区物业、开发经验。'
          ]
        },
        {
          upshow: true,
          name: '营销开拓专员/网络营销专员',
          en: 'Marketing development specialist/Internet Marketing Specialist',
          need: '岗位职责',
          intr: [
            '1、负责家装渠道的客源获取、登记、约访、签单，并把市场部获取的客户分发个设计师，保证合理分配；',
            '2、负责相关资源分配管理及客户签单与施工阶段的维护；',
            '3、设计师签单期间，协助设计师顺利签单；'
          ],
          require: [
            '1、年龄30岁以上，2年以上家装行业或相关工作经验；',
            '2、有在大型著名装修企业工作资历者优先。；',
            '3、良好的沟通技巧，及较强的团队意识和服务意识；',
            '4、责任心强，有较强的学习能力。'
          ]
        },
        {
          upshow: true,
          name: '采购专员',
          en: 'Purchasing Specialist',
          need: '岗位职责',
          intr: [
            '1、负责装修材料、装修工程采购，负责市场物料和行政办公用品采购；',
            '2、熟悉和掌握市场行情，按“质优、价廉”的原则货比三家，择优采购，注重收集市场信息，及时向部门领导反馈市场价格和有关信息。合理安排采购计划；',
            '3、 严把采购质量关，物资选择样品供使用部门审核定样。积极协助有关部门妥善解决使用过程中会出现的问题；',
            '4、加强与验收、保管人员的协作，有责任提供有效的物品保管方法，防止物品保管不妥而受损失；',
            '5、完成领导交办的其它各项工作。'
          ],
          require: [
            '1、本科以上学历，专业不限；',
            '2、2年以上工程、行政或行销采购经验，熟悉采购流程和合同谈判技巧，有财务背景佳；',
            '3、高度认可企业文化，拥有良好的道德品质，正直、有责任心。',
            '4、熟练使用企业ERP系统优先；',
            '5、了解家居建材，如地板瓷砖，了解家居品牌软装优先'
          ]
        },
        {
          upshow: true,
          name: '工程经理',
          en: 'Project manager',
          need: '岗位职责',
          intr: [
            '1、项目精装修工程的设计协调和现场施工管理工作。',
            '2、协调土建、安装等专业工程的现场配合工作，完成现场装饰工程施工日志的准确记录；负责每日的现场巡查工作，并作好巡查记录； ',
            '3、协助装饰工程项目的现场施工进度, 确保装饰工程项目进度计划的完成； ',
            '4、 严格监督装饰工程项目施工质量, , 对现场安全文明施工负责；',
            '5、 做好工程交付工作，做好装饰资料合理归档和移交。'
          ],
          require: [
            '1、本科以上学历，工程管理及土木工程等建筑、装饰相关专业；',
            '2、3年以上装修工程工作经验；',
            '3、熟悉装饰工艺标准和国家规范；',
            '4、熟悉各种装饰材料和装潢施工流程；',
            '5、熟练运用相关办公软件，电脑操作熟练；',
            '6、具有良好的沟通、协调和管理控制能力；',
            '7、热爱本职工作，吃苦耐劳，认真敬业，诚实守信。'
          ]
        },
        {
          upshow: true,
          name: '智能硬件工程师',
          en: 'Intelligent hardware engineer',
          need: '岗位职责',
          intr: [
            '1、1.负责智能开关、智能照明等智能家居产品项目的硬件开发设计工作。包括需求和规格分析、器件选型、硬件系统方案设计、原理图设计、BOM制作、硬件调测、EMC测试和整改、生产试制等工作。',
            '2、负责本团队硬件项目的整体质量把关，包括原理图、PCB、测试报告等设计评审把关。',
            '3、负责项目沟通并制订硬件计划，和硬件相关领域如BSP、 采购、材料、热设计、结构、Layout等领域进行相关沟通和协调管理。'
          ],
          require: [
            '1、本科及以上学历，电子科学与技术、自动化、通信工程等相关专业，从事硬件开发工作5年以上。有智能家居产品硬件开发经验者优先。',
            '2、具有熟练的MCU软件编程能力及调试经验；',
            '3、具有较好的电子电路设计功底，熟练使用至少一款PCB版图设计软件；',
            '4、具有较强的硬件电路调试能力、分析能力和学习能力；',
            '5、对于近距离无线RF（射频）方向如2.4G、BLE等有一定涉及和应用经验者优先；',
            '6、具有LED驱动及电源项目经验及调试经验者优先。'
          ]
        }
      ]
    }
  },
  methods: {
    up (e, item) {
      item.upshow = true
      let ev = e.currentTarget
      $(ev).parent('.con').parent('.lis').animate({height: '180px'}, '500')
      $(ev).parent('.con').delay(1000).animate({height: '120px'}, '500')
    },
    down (ev, item) {
      item.upshow = false
      let eve = ev.currentTarget
      let h = $(eve).prev().height() + 340
      let hh = $(eve).prev().height() + 260
      $(eve).parent('.con').parent('.lis').animate({height: h}, '500')
      $(eve).parent('.con').animate({height: hh}, '500')
    }
  },
  components: {
    Head, foot
  }
}
</script>
<style scoped>
  .joinH {
    position: relative;
    margin-top: 88px;
  }
  .banner {
    height: 205px;
    background: url('../assets/joinUs/banner.png') no-repeat;
    background-size: 100% 205px;
  }
  h3 {
    font-size: 48px;
    letter-spacing: 1px;
    color: #3e3a39;
    text-align: center;
    margin: 25px 0 10px 0;
  }
  .subhead {
    font-size: 18px;
    color: #3e3a39;
    text-align: center;
  }
  .list {
    width: 702px;
    text-align: left;
    margin: 49px auto 23px;
  }
  .list > li {
    height: 110px;
    border: 1px solid #9fa0a0;
    margin-bottom: 24px;
    overflow: hidden;
    position: relative;
    transition-duration: .5s;
  }
  .con {
    width: 641px;
    height: 50px;
    margin: 33px auto 28px;
    overflow: hidden;
  }
  .list li h1 {
    font-size: 24px;
    letter-spacing: 1px;
    color: #3e3a39;
  }
  .en {
    font-size: 16px;
    color: #898989;
    margin: 8px 0 32px;
  }
  .need {
    font-size: 16px;
    line-height: 30px;
    color: #727171;
  }
  .re {
    margin: 44px 0 14px;
  }
  .con > span {
    font-size: 16px;
    color: #ffffff;
    display: inline-block;
    width: 180px;
    height: 48px;
    background-color: #d42f31;
    text-align: center;
    line-height: 48px;
    margin: 27px 24px 0 0;
    cursor: pointer;
  }
  .upDown {
    width: 31px;
    height: 31px;
    display: block;
    position: absolute;
    top: 40px;
    right: 42px;
  }
</style>
